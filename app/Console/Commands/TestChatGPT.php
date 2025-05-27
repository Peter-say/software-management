<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestChatGPT extends Command
{
    protected $signature = 'test:chatgpt';
    protected $description = 'Send a test message to ChatGPT API';

    public function handle()
    {
        $response = Http::withToken('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')->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello, ChatGPT from Laravel CLI!']
            ],
        ]);
        dd($response->json());
        $this->info("Response: " . $response['choices'][0]['message']['content']);
    }
}
