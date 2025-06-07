<?php

namespace App\Services\PageSpeedInsight;

class PageSpeedInsight
{
    public function fetchPageSpeedMetrics(string $url): array
    {
        $apiKey = env('PAGE_SPEED_INSIGHT_KEY');
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" . urlencode($url) . "&key={$apiKey}";
        $response = @file_get_contents($apiUrl);

        if (!$response) {
            return [
                'LCP' => 'N/A',
                'CLS' => 'N/A',
                'INP' => 'N/A',
                'recommendations' => 'Failed to fetch PageSpeed Insights metrics.',
            ];
        }

        $data = json_decode($response, true);
        
        $lcp = $data['lighthouseResult']['audits']['largest-contentful-paint']['displayValue'] ?? 'N/A';
        $cls = $data['lighthouseResult']['audits']['cumulative-layout-shift']['displayValue'] ?? 'N/A';
        $inp = $data['lighthouseResult']['audits']['interaction-to-next-paint']['displayValue'] ?? 'N/A';

        $recommendations = collect($data['lighthouseResult']['audits'])
            ->filter(fn($audit) => $audit['score'] !== 1)
            ->map(fn($audit) => $audit['title'])
            ->implode(', ');

        return [
            'LCP' => $lcp,
            'CLS' => $cls,
            'INP' => $inp,
            'recommendations' => $recommendations ?: 'Good performance metrics.',
        ];
    }

    public function checkHttpsAndCanonical(string $url, string $html): array
    {
        $isHttps = str_starts_with($url, 'https://');

        preg_match('/<link rel="canonical" href="([^"]+)"/i', $html, $matches);
        $canonicalUrl = $matches[1] ?? null;

        return [
            'indexable' => !preg_match('/<meta name="robots" content="noindex"/i', $html),
            'https' => $isHttps,
            'canonical' => [
                'exists' => !empty($canonicalUrl),
                'url' => $canonicalUrl,
            ],
            'notes' => $isHttps ? 'HTTPS in use.' : 'Page not served over HTTPS.',
        ];
    }
    public function findBrokenLinks(string $html): array
    {
        preg_match_all('/href="([^"]+)"/i', $html, $matches);
        $links = array_unique($matches[1] ?? []);

        $brokenLinks = [];
        foreach ($links as $link) {
            if (filter_var($link, FILTER_VALIDATE_URL)) {
                $headers = @get_headers($link);
                if (!$headers || strpos($headers[0], '200') === false) {
                    $brokenLinks[] = $link;
                }
            }
        }
        return $brokenLinks;
    }
}
