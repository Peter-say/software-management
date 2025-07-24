<?php

namespace App\Services\API\V1\Assistant;

use App\Models\SeoAnalysis;
use App\Models\User;
use App\Services\AI\Gemini\GeminiService;
use App\Services\PageSpeedInsight\PageSpeedInsight;
use App\Services\SiteInspectorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;

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
            'content' => 'nullable|string',
            'question_context' => 'nullable|string',
            'ai_type' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'prompt' => 'nullable|string', // Optional, for question_context handling
            'response' => 'nullable', // Optional, for question_context handling
            'screenshot_url' => 'nullable|url',
            'uuid' => 'nullable|uuid',
        ]);

        $validator->after(function ($validator) use ($data) {
            if (
                empty($data['html_input']) &&
                empty($data['url']) &&
                empty($data['content']) &&
                empty($data['question_context'])
            ) {
                $validator->errors()->add('html_input', 'Either html_input, url, content, or question_context must be provided.');
                $validator->errors()->add('url', 'Either html_input, url, content, or question_context must be provided.');
                $validator->errors()->add('content', 'Either html_input, url, content, or question_context must be provided.');
                $validator->errors()->add('question_context', 'Either html_input, url, content, or question_context must be provided.');
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
                'content',
                'question_context',
                'ai_type',
                'title',
                'response', // Optional, for question_context handling
            ]));

            $htmlContent = $data['html_input'] ?? null;
            $url = $data['url'] ?? null;
            $content = $data['content'] ?? null;


            if ($url && !$htmlContent) {
                $htmlContent = @file_get_contents($url);
            }
            $title = $data['title'] ?? $this->generateTitleFromPrompt($htmlContent ?? $url ?? $content ?? '', $url);
            // Log::info('SEO Analyzer generated title', ['title' => $title, 'hello' => $data]);
            $instructionsJson = Storage::get('ai_contexts/seoanalyzer_instructions.json');
            $instructions = json_decode($instructionsJson, true);
            //  dd($title);
            // If question_context is present, handle only that
            if (!empty($data['question_context'])) {
                $response = $data['response'] ?? '';
                $systemPrompt = "Please, give a clear recommended approach to fix the issues in: {$response}" .
                    " with the question: {$data['question_context']}";
                $response = $this->gemini_service->sendPrompt($systemPrompt);
                return [
                    'response' => $response,
                ];
            }

            // Otherwise, do the full analysis
            $userPrompt = $htmlContent ?? "Please analyze the page at this URL: {$url}";

            $screenshotUrl = null;
            $pageSpeedMetrics = $indexability = $brokenLinks = [];
            if ($content) {
                $systemPrompt = "Please analyze this page content: {$content}. " .
                    "If there are any issues, give a clear recommended approach to fix them. " .
                    "If not, explain why the content is okay.";

                $response = $this->gemini_service->sendPrompt($systemPrompt);
                $uuid = $this->resolveAnalysisUuid($data, $user);

                return [
                    'uuid' => $uuid,
                    'prompt' => $systemPrompt,
                    'title' => $title,
                    'response' => $response,
                ];
            }

            if ($url ?? $htmlContent) {
                $screenshotUrl = null;
                $screenshotUrl = $this->getScreenshot($url);
                $pageSpeedMetrics = $this->page_speed_insight->fetchPageSpeedMetrics($url);
                $indexability = $this->page_speed_insight->checkHttpsAndCanonical($url, $htmlContent ?? '');
                $brokenLinks = $this->page_speed_insight->findBrokenLinks($htmlContent ?? '', $url);

                $systemPrompt = $this->buildPrompt($instructions, $userPrompt, $pageSpeedMetrics, $indexability, $brokenLinks);
                $rawResponse = $this->gemini_service->sendPrompt($systemPrompt);
                $parsedResponse = json_decode($this->stripCodeBlock($rawResponse), true) ?? [];
                $uuid = $this->resolveAnalysisUuid($data, $user);
                return [
                    'uuid' => $uuid,
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
            }
        });
    }

    public function saveAnalysis(Request $request): array
    {
        return DB::transaction(function () use ($request) {
            $user = User::getAuthenticatedUser();
            $data = $this->validated($request->only([
                'html_input',
                'url',
                'title',
                'prompt',
                'response',
                'content',
                'uuid', // Optional, for updating existing analysis
            ]));
            $query = SeoAnalysis::where('user_id', $user->id)->where('uuid', $data['uuid'] ?? null);

            if (!empty($data['html_input'])) {
                $query->where('html_input', $data['html_input']);
            } elseif (!empty($data['url'])) {
                $query->where('url', $data['url']);
            }

            $analysis = $query->first();

            // 🟡 Check for duplicate/similar content if analysis not found
            if (!$analysis && !empty($data['content'])) {
                $existing = SeoAnalysis::where('user_id', $user->id)->get();
                foreach ($existing as $item) {
                    $existingContent = strtolower($item->html_input ?? $item->content ?? '');
                    $newContent = strtolower($data['html_input'] ?? $data['content']);

                    similar_text($existingContent, $newContent, $percent);
                    if ($percent >= 80) {
                        $analysis = $item;
                        break;
                    }
                }
            }

            $payload = [
                'title' => $data['title'] ?? null,
                'input_type' => !empty($data['html_input']) ? 'html' : (!empty($data['content']) ? 'content' : 'url'),
                'html_input' => $data['html_input'] ?? null,
                'url' => $data['url'] ?? null,
                'content' => $data['content'] ?? null,
                'prompt' => $data['prompt'] ?? null,
                'response' => $data['response'] ?? [],
            ];

            if ($analysis) {
                $analysis->update($payload);
                $status = 'updated';
            } else {
                $payload['uuid'] = $data['uuid'];
                $payload['user_id'] = $user->id;
                $analysis = SeoAnalysis::create($payload);
                $status = 'created';
            }

            return [
                'analysis' => SeoAnalysis::with('user')->find($analysis->id),
                'status' => $status,
            ];
        });
    }

    public function clearAnalysis($uuid)
    {
        $user = User::getAuthenticatedUser();
        $analysis = SeoAnalysis::where('user_id', $user->id)
            ->where('uuid', $uuid)
            ->first();

        if (!$analysis) {
            return response()->json(['message' => 'Analysis not found'], 404);
        }
        $analysis->delete();
    }

    public function clearAnalyses()
    {
        $user = User::getAuthenticatedUser();
        $analyses = SeoAnalysis::where('user_id', $user->id)->get();

        if (!$analyses) {
            return response()->json(['message' => 'Analyses not found'], 404);
        }
        foreach ($analyses as $analysis) {
            $analysis->delete();
        }
    }


    protected function resolveAnalysisUuid(array $data, User $user): string
    {
        $uuid = $data['uuid'] ?? null;
        $url = $data['url'] ?? null;

        if (!$uuid && $url) {
            $existing = SeoAnalysis::where('user_id', $user->id)
                ->where('url', $url)->first();
            if ($existing) {
                $uuid = $existing->uuid;
            } else {
                $uuid = (string) Str::uuid();
            }
        } elseif (!$uuid) {
            $uuid = (string) Str::uuid();
        }

        return $uuid;
    }

    public function getScreenshot(string $url): string
    {
        try {
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
        } catch (Exception $e) {
            if (str_contains($e->getMessage(), 'net::ERR_INTERNET_DISCONNECTED')) {
                throw new RuntimeException('Internet connection appears to be offline. Please check your connection and try again.');
            }
            throw new RuntimeException('Failed to capture screenshot. Please check your internet connection and ensure the URL is accessible.');
        }
    }

    protected function stripCodeBlock(string $text): string
    {
        return trim(preg_replace('/^```[a-z]*\s*|\s*```$/i', '', $text));
    }



    protected function generateTitleFromPrompt(string $input, ?string $url = null): ?string
    {
        $text = trim(strip_tags($input));
        $words = preg_split('/\s+/', $text);

        // If only one word, don't generate a title
        if (count($words) <= 1) {
            return null;
        }

        // If the prompt contains 'analyze' and a URL is provided
        if ($url && stripos($text, 'analyze') !== false) {
            return 'Analyze ' . $url;
        }

        // Try to extract <title> from HTML input
        if ($input && stripos($input, '<title>') !== false) {
            if (preg_match('/<title>(.*?)<\/title>/is', $input, $matches)) {
                $titleTag = trim($matches[1]);
                if ($titleTag) {
                    return $titleTag;
                }
            }
        }

        // Fallback 1: Generate from the first few words if meaningful
        $cleanText = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        $cleanWords = array_filter(explode(' ', trim($cleanText)));

        if (count($cleanWords) >= 15) {
            return ucfirst(implode(' ', array_slice($cleanWords, 0, 15))) . '...';
        }

        // Fallback 2: Ask AI to generate a title from the content
        $systemPrompt = <<<PROMPT
Please generate a concise and descriptive SEO-friendly title for the following content. 
Ensure the title summarizes the main subject and is written in proper title case. 
Avoid generic phrases. Only return the title.

Content:
\"\"\"{$text}\"\"\"
PROMPT;

        $aiTitle = $this->gemini_service->sendPrompt($systemPrompt);

        // Ensure a non-empty string is returned
        return is_string($aiTitle) && trim($aiTitle) !== '' ? trim($aiTitle) : null;
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
