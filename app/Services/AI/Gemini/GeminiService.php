<?php

namespace App\Services\AI\Gemini;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function __construct()
    {
        // Initialize any dependencies here
    }

    public function sendPrompt(string $prompt)
    {
        if (empty($prompt) || strlen($prompt) > 500) {
            throw new \InvalidArgumentException('Prompt is required and must be less than 500 characters.');
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);
        if (!$response->successful()) {
            throw new \Exception('Gemini API error: ' . $response->body());
        }
        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No reply';
        return $text;
    }
}
