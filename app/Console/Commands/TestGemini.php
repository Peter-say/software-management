<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestGemini extends Command
{
    protected $signature = 'test:gemini {prompt}';
    protected $description = 'Send prompt to Google Gemini AI';

    public function handle()
    {
        $prompt = $this->argument('prompt');

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

        $data = $response->json();

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No reply';
        $this->info("Gemini says: " . $text);
    }
}
