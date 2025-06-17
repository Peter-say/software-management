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
                'FCP' => 'N/A',
                'TTFB' => 'N/A',
                'TTI' => 'N/A',
                'TBT' => 'N/A',
                'speed_index' => 'N/A',
                'recommendations' => 'Failed to fetch PageSpeed Insights metrics.',
            ];
        }

        $data = json_decode($response, true);
        $audits = $data['lighthouseResult']['audits'] ?? [];

        $lcp = $audits['largest-contentful-paint']['displayValue'] ?? 'N/A';
        $cls = $audits['cumulative-layout-shift']['displayValue'] ?? 'N/A';
        $inp = $audits['interaction-to-next-paint']['displayValue'] ?? 'N/A';
        $fcp = $audits['first-contentful-paint']['displayValue'] ?? 'N/A';
        $ttfb = $audits['server-response-time']['displayValue'] ?? 'N/A';
        $tti = $audits['interactive']['displayValue'] ?? 'N/A';
        $tbt = $audits['total-blocking-time']['displayValue'] ?? 'N/A';
        $speedIndex = $audits['speed-index']['displayValue'] ?? 'N/A';
        $recommendations = collect($audits)
            ->filter(fn($audit) => isset($audit['score']) && $audit['score'] !== 1)
            ->map(function ($audit) {
            $title = $audit['title'] ?? '';
            $description = $audit['description'] ?? '';
            return $title . ': ' . $description;
            })
            ->implode(', ');

        return [
            'LCP' => $lcp,
            'CLS' => $cls,
            'INP' => $inp,
            'FCP' => $fcp,
            'TTFB' => $ttfb,
            'TTI' => $tti,
            'TBT' => $tbt,
            'speed_index' => $speedIndex,
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
    public function analyzePage(string $url, string $html): array
    {
        $baseUrl = $this->getBaseUrl($url);
        return $this->findBrokenLinks($html, $baseUrl);
    }

    public function findBrokenLinks(string $html, string $baseUrl): array
    {
        preg_match_all('/href="([^"]+)"/i', $html, $matches);
        $links = array_unique($matches[1] ?? []);

        $brokenLinks = [];
        foreach ($links as $link) {
            // Convert relative links to absolute
            $absoluteLink = $this->makeAbsoluteUrl($link, $baseUrl);

            if ($absoluteLink && filter_var($absoluteLink, FILTER_VALIDATE_URL)) {
                $headers = @get_headers($absoluteLink);
                if (!$headers || strpos($headers[0], '200') === false) {
                    $brokenLinks[] = $absoluteLink;
                }
            }
        }

        return $brokenLinks;
    }

    private function makeAbsoluteUrl(string $link, string $baseUrl): ?string
    {
        if (parse_url($link, PHP_URL_SCHEME)) {
            return $link; // Already absolute
        }

        $baseUrl = rtrim($baseUrl, '/') . '/';

        if (strpos($link, '/') === 0) {
            $parsedBase = parse_url($baseUrl);
            return $parsedBase['scheme'] . '://' . $parsedBase['host'] . $link;
        }

        return $baseUrl . ltrim($link, '/');
    }

    private function getBaseUrl(string $url): string
    {
        $parts = parse_url($url);
        if (!isset($parts['scheme']) || !isset($parts['host'])) {
            throw new \InvalidArgumentException("Invalid URL: $url");
        }
        return $parts['scheme'] . '://' . $parts['host'];
    }
}
