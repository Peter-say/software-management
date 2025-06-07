<?php

namespace App\Services\SiteInspector;

class SiteInspectorService
{
    public function checkSiteAccessibility(string $url): array
    {
        $headers = @get_headers($url, 1);

        if ($headers === false) {
            return ['status' => false, 'message' => 'Site is unreachable or does not exist.'];
        }

        $statusLine = $headers[0] ?? '';

        if (str_contains($statusLine, '403') || str_contains($statusLine, '401')) {
            return ['status' => false, 'message' => 'Site is blocking access (403/401 Forbidden).'];
        }

        if (str_contains($statusLine, '404')) {
            return ['status' => false, 'message' => 'Site not found (404).'];
        }

        if (str_contains($statusLine, '503')) {
            return ['status' => false, 'message' => 'Site is temporarily unavailable (503).'];
        }

        return ['status' => true, 'message' => 'OK'];
    }

    public function isCrawlingBlocked(string $url): bool
    {
        $parsed = parse_url($url);
        if (!isset($parsed['scheme'], $parsed['host'])) {
            return false;
        }

        $robotsUrl = "{$parsed['scheme']}://{$parsed['host']}/robots.txt";

        $robotsTxt = @file_get_contents($robotsUrl);
        if (!$robotsTxt) return false; // No robots.txt = allow by default

        return preg_match('/Disallow:\s*\/\s*/i', $robotsTxt) > 0;
    }

    public function fetchWithTimeout(string $url, int $timeout = 5): ?string
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => $timeout,
                'user_agent' => 'Mozilla/5.0 (compatible; SEOAnalyzer/1.0)',
            ]
        ]);

        return @file_get_contents($url, false, $context) ?: null;
    }

    public function inspect(string $url): array
    {
        $check = $this->checkSiteAccessibility($url);
        if (!$check['status']) {
            return [
                'error' => true,
                'message' => $check['message'],
            ];
        }

        if ($this->isCrawlingBlocked($url)) {
            return [
                'error' => true,
                'message' => 'Access Denied by robots.txt — The target website is preventing crawlers from accessing its pages. 
To proceed with SEO analysis, please ensure the robots.txt file permits user-agent access to relevant sections of the site. 
<a href="https://developers.google.com/search/docs/crawling-indexing/robots/intro" target="_blank" rel="noopener">Learn how to configure your robots.txt file here</a>.'

            ];
        }

        $html = $this->fetchWithTimeout($url);
        if (!$html) {
            return [
                'error' => true,
                'message' => 'Failed to fetch content within timeout. The site may be slow or blocking bots.',
            ];
        }

        return [
            'error' => false,
            'message' => 'Successfully fetched site content.',
            'html' => $html,
        ];
    }
}
