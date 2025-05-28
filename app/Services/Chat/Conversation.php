<?php

namespace App\Services\Chat;

use App\Models\Chat;
use App\Models\Conversation as ModelsConversation;
use App\Models\User;
use App\Services\AI\Gemini\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

            $user = User::getAuthenticatedUser();
            $role = $user->role;
            $roleDescription = $json['user_roles'][$role] ?? 'Role description not found.';
            $instructionsJson = Storage::get('ai_contexts/hotelmaster_instructions.json');
            $instructions = json_decode($instructionsJson, true);

            $systemPrompt = "You are an assistant for the HotelMaster app. Here's the app context:\n\n"
                . json_encode($instructions, JSON_PRETTY_PRINT)
                . "\n\nUser Info:\nRole: {$role}\nRole Description: {$roleDescription}";

            $responseText = $this->gemini_service->sendPrompt($systemPrompt . "\n\nUser asked: " . $request->prompt);
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
        if (empty($conversations)) {
            return [
                'message' => 'No conversations found to clear',
            ];
        }
        foreach ($conversations as $conversation) {
            $conversation->chats()->delete();
            $conversation->delete();
        }
        return [
            'message' => 'Conversation cleared successfully',
        ];
    }
}
