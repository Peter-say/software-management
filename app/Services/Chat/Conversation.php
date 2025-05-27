<?php

namespace App\Services\Chat;

use App\Models\Chat;
use App\Models\Conversation as ModelsConversation;
use App\Models\User;
use App\Services\AI\Gemini\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Conversation
{
    protected $gemini_service;

    public function __construct()
    {
        $this->gemini_service = new GeminiService();
    }

    public function validated(array $data)
    {
        $validator = Validator::make($data, [
            'conversation_id' => 'required|integer',
            'ai_type' => 'required|string',
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function createConversation(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::getAuthenticatedUser();

            // Auto-generate title from prompt
            $title = $this->generateTitleFromPrompt($request->prompt);

            $validated = $this->validated([
                'conversation_id' => $request->conversation_id ?? 0,
                'ai_type' => $request->ai_type,
                'title' => $title,
            ]);

            $conversation = ModelsConversation::firstOrCreate([
                'user_id' => $user->id,
                'ai_type' => $validated['ai_type'],
                'title' => $validated['title'],
            ]);

            // Save user prompt
            $prompt = new Chat([
                'sender' => 'user',
                'content' => $request->prompt,
            ]);
            $conversation->chats()->save($prompt);

            // Check for user statistics query
            $keywords = ['how many', 'users', 'day', 'week', 'month', 'year', 'total', 'count', 'statistics'];
            $promptLower = strtolower($request->prompt);
            $isUserQuery = false;
            foreach ($keywords as $keyword) {
                if (strpos($promptLower, $keyword) !== false) {
                    $isUserQuery = true;
                    break;
                }
            }

            if ($isUserQuery) {
                $period = null;
                foreach (['day', 'week', 'month', 'year'] as $p) {
                    if (strpos($promptLower, $p) !== false) {
                        $period = $p;
                        break;
                    }
                }
                if ($period) {
                    $sql = $this->getUserQueryWithGemini($period);
                    $result = DB::select($sql);
                    $dbText = "User statistics by $period:\n";
                    foreach ($result as $row) {
                        $dbText .= implode(', ', (array)$row) . "\n";
                    }

                    // Ask Gemini to explain the DB result
                    $geminiPrompt = "The user asked: '{$request->prompt}'. Here is the data from the database:\n{$dbText}\nPlease explain or summarize this result for the user in plain language.";
                    $explainedText = $this->gemini_service->sendPrompt($geminiPrompt);

                    // Save AI response
                    $response = new Chat([
                        'sender' => 'ai',
                        'content' => $explainedText,
                    ]);
                    $conversation->chats()->save($response);

                    return [
                        'conversation' => $conversation,
                        'prompt' => $request->prompt,
                        'response' => $explainedText,
                    ];
                }
            }

            // Default: send prompt to Gemini as usual
            $responseText = $this->gemini_service->sendPrompt($request->prompt);
            $response = new Chat([
                'sender' => 'ai',
                'content' => $responseText,
            ]);
            $conversation->chats()->save($response);

            return [
                'conversation' => $conversation,
                'prompt' => $request->prompt,
                'response' => $responseText,
            ];
        });
    }

    protected function generateTitleFromPrompt(string $prompt): string
    {
        $words = explode(' ', strip_tags($prompt));
        return ucfirst(implode(' ', array_slice($words, 0, 6))) . (count($words) > 6 ? '...' : '');
    }

    public function clearConversation(Request $request)
    {
        $user = User::getAuthenticatedUser();
        $conversations = ModelsConversation::where('user_id', $user->id)
            ->where('ai_type', 'gemini')
            ->get();
        foreach ($conversations as $conversation) {
            $conversation->chats()->delete();
            $conversation->delete();
        }
        return [
            'message' => 'Conversation cleared successfully',
        ];
    }


    public function getUserQueryWithGemini(string $period): string
    {
        $allowedPeriods = ['day', 'week', 'month', 'year', 'total'];
        if (!in_array(strtolower($period), $allowedPeriods)) {
            throw new \InvalidArgumentException('Invalid period specified.');
        }

        switch (strtolower($period)) {
            case 'day':
                $sql = "SELECT COUNT(*) as total FROM users WHERE DATE(created_at) = CURDATE()";
                break;
            case 'week':
                $sql = "SELECT COUNT(*) as total FROM users WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
                break;
            case 'month':
                $sql = "SELECT COUNT(*) as total FROM users WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())";
                break;
            case 'year':
                $sql = "SELECT COUNT(*) as total FROM users WHERE YEAR(created_at) = YEAR(CURDATE())";
                break;
            case 'total':
                $sql = "SELECT COUNT(*) as total FROM users";
                break;
            default:
                throw new \InvalidArgumentException('Invalid period specified.');
        }

        if (!preg_match('/^SELECT/i', trim($sql))) {
            throw new \RuntimeException('Unsafe query');
        }
        return $sql;
    }
}
