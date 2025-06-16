<?php

namespace App\Services\API\V1\Assistant;

use App\Models\User;
use App\Services\AI\Gemini\GeminiService;
use App\Services\PageSpeedInsight\PageSpeedInsight;
use App\Services\SiteInspectorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Browsershot\Browsershot;

class SeoAnalyzer
{
    protected $gemini_service;
    protected $page_speed_insight;


    public function __construct()
    {
        $this->gemini_service = new GeminiService();
        $this->page_speed_insight = new PageSpeedInsight();
    }

    public function validated(array $data)
    {
        $validator = Validator::make($data, [
            'html_input' => 'nullable|string',
            'url' => 'nullable|url',
            'question_context' => 'nullable|string',
            'conversation_id' => 'nullable|integer|min:0',
            'ai_type' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'response' => 'nullable|string', // Optional, for question_context handling
        ]);

        $validator->after(function ($validator) use ($data) {
            if (
                empty($data['html_input']) &&
                empty($data['url']) &&
                empty($data['question_context'])
            ) {
                $validator->errors()->add('html_input', 'Either html_input, url, or question_context must be provided.');
                $validator->errors()->add('url', 'Either html_input, url, or question_context must be provided.');
                $validator->errors()->add('question_context', 'Either html_input, url, or question_context must be provided.');
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }


    public function analyzer(Request $request): array
    {
        return DB::transaction(function () use ($request) {
            $user = User::getAuthenticatedUser();
            $data = $this->validated($request->only([
                'html_input',
                'url',
                'question_context',
                'conversation_id',
                'ai_type',
                'title',
                'response', // Optional, for question_context handling
            ]));

            $htmlContent = $data['html_input'] ?? null;
            $url = $data['url'] ?? null;

            if ($url && !$htmlContent) {
                $htmlContent = @file_get_contents($url);
            }
            $title = $data['title'] ?? $this->generateTitleFromPrompt($htmlContent ?? $url ?? '');
            // Load instructions
            $instructionsJson = Storage::get('ai_contexts/seoanalyzer_instructions.json');
            $instructions = json_decode($instructionsJson, true);

            // If question_context is present, handle only that
            if (!empty($data['question_context'])) {
                $response = $data['response'] ?? '';
                $systemPrompt = "Please, give a clear recommended approach to fix the issues in: {$response}" .
                    " with the question: {$data['question_context']}";
                $response = $this->gemini_service->sendPrompt($systemPrompt);
                // $parsedResponse = json_decode($this->stripCodeBlock($rawResponse), true) ?? [];
                return [
                    'response' => $response,
                ];
            }

            // Otherwise, do the full analysis
            $userPrompt = $htmlContent ?? "Please analyze the page at this URL: {$url}";
            $screenshotUrl = null;
            $pageSpeedMetrics = $indexability = $brokenLinks = [];
            if ($url) {
                $screenshotUrl = $this->getScreenshot($url);
                $pageSpeedMetrics = $this->page_speed_insight->fetchPageSpeedMetrics($url);
                $indexability = $this->page_speed_insight->checkHttpsAndCanonical($url, $htmlContent ?? '');
                $brokenLinks = $this->page_speed_insight->findBrokenLinks($htmlContent ?? '', $url);
            }

            $systemPrompt = $this->buildPrompt($instructions, $userPrompt, $pageSpeedMetrics, $indexability, $brokenLinks);
            $rawResponse = $this->gemini_service->sendPrompt($systemPrompt);
            $parsedResponse = json_decode($this->stripCodeBlock($rawResponse), true) ?? [];

            return [
                'prompt' => $systemPrompt,
                'title' => $title,
                'raw_response' => $rawResponse,
                'response' => array_merge($parsedResponse, [
                    'pagespeed_metrics' => $pageSpeedMetrics,
                    'indexability_https' => $indexability,
                    'broken_links' => $brokenLinks,
                    'screenshot_url' => $screenshotUrl,
                ]),
            ];
        });
    }

    public function getScreenshot(string $url): string
    {
        $fileName = md5($url . microtime()) . '.png';
        $savePath = storage_path('app/public/screenshots/' . $fileName); // <-- use 'public/screenshots'

        if (!file_exists(storage_path('app/public/screenshots'))) {
            mkdir(storage_path('app/public/screenshots'), 0777, true);
        }

        Browsershot::url($url)
            ->windowSize(1280, 800)
            ->waitUntilNetworkIdle()
            ->save($savePath);

        return asset('storage/screenshots/' . $fileName);
    }

    protected function stripCodeBlock(string $text): string
    {
        return trim(preg_replace('/^```[a-z]*\s*|\s*```$/i', '', $text));
    }


    protected function generateTitleFromPrompt(string $input): string
    {
        $text = strip_tags($input);
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        $words = explode(' ', trim($text));
        return ucfirst(implode(' ', array_slice($words, 0, 6))) . (count($words) > 6 ? '...' : '');
    }


    protected function formatInstructions(array $instructions): string
    {
        return collect($instructions['instructions'] ?? [])
            ->map(fn($i) => "- **{$i['task']}**: {$i['description']}")
            ->implode("\n");
    }
    protected function buildPrompt(
        $instructions,
        $userPrompt,
        $pageSpeedMetrics,
        $indexability,
        $brokenLinks
    ): string {
        $brokenLinksCount = count($brokenLinks);
        $brokenLinksSample = implode(', ', array_slice($brokenLinks, 0, 5));
        if ($brokenLinksCount > 5) {
            $brokenLinksSample .= '...';
        }

        // Core Web Vitals
        $lcp = $pageSpeedMetrics['LCP'] ?? 'N/A';
        $cls = $pageSpeedMetrics['CLS'] ?? 'N/A';
        $inp = $pageSpeedMetrics['INP'] ?? 'N/A';

        // Additional PageSpeed Metrics
        $fcp = $pageSpeedMetrics['FCP'] ?? 'N/A';
        $ttfb = $pageSpeedMetrics['TTFB'] ?? 'N/A';
        $tti = $pageSpeedMetrics['TTI'] ?? 'N/A';
        $tbt = $pageSpeedMetrics['TBT'] ?? 'N/A';
        $speedIndex = $pageSpeedMetrics['speed_index'] ?? 'N/A';

        $recommendations = $pageSpeedMetrics['recommendations'] ?? 'N/A';

        // Indexability Info
        $https = isset($indexability['https']) && $indexability['https'] ? 'Yes' : 'No';
        $canonical = $indexability['canonical']['url'] ?? 'None';
        $indexable = isset($indexability['indexable']) && $indexability['indexable'] ? 'Yes' : 'No';
        $notes = $indexability['notes'] ?? '';

        // Section: Metrics
        $extraMetrics = <<<EXTRA

## PageSpeed Metrics
- LCP (Largest Contentful Paint): {$lcp}
- INP (Interaction to Next Paint): {$inp}
- CLS (Cumulative Layout Shift): {$cls}
- FCP (First Contentful Paint): {$fcp}
- TTFB (Time to First Byte): {$ttfb}
- TTI (Time to Interactive): {$tti}
- TBT (Total Blocking Time): {$tbt}
- Speed Index: {$speedIndex}
- Recommendations: {$recommendations}

## HTTPS & Canonical Info
- HTTPS: {$https}
- Canonical: {$canonical}
- Indexable: {$indexable}
- Notes: {$notes}

## Broken Links
- Count: {$brokenLinksCount}
- Links: {$brokenLinksSample}

EXTRA;

        $instructionsFormatted = $this->formatInstructions($instructions);

        return <<<EOT
You are an SEO assistant. Analyze the provided HTML or webpage content and return the response in the following JSON format. Provide definitive results. If certain data is
missing or cannot be determined, state that explicitly. Avoid vague terms like "might" or "possibly." 
Also include a suggested_questions array with 4 to 8 diverse and insightful follow-up questions tailored to the webpage or HTML provided. 
Avoid generic or repeated suggestions. 
Base your questions on actual SEO findings from the analysis.

Format:
{
  "meta_suggestions": {
    "title": "string",
    "description": "string"
    "recommendations": "string"
  },
  "headings": {
    "current": ["H1", "H2", "H3", "..."],
    "recommendations": "string"
  },
  "keywords": ["keyword1", "keyword2", "..."],
  "internal_link_opportunities": ["string"],
  "missing_alt_tags": ["img src or summary"],
  "seo_score": {
    "score": "1-10",
    "reason": "string with summary of SEO strengths and improvements"
  },
  "suggested_questions": [
    "What are the most urgent SEO issues?",
    "How can I increase my page speed?",
    "Is my internal linking structure effective?"
  ]
}

## Instructions
{$instructionsFormatted}

## Webpage Content
{$userPrompt}

{$extraMetrics}
EOT;
    }
}
