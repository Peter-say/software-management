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
            'prompt' => 'required|string',
            'conversation_id' => 'nullable|integer|min:0',
            'ai_type' => 'nullable|string',
            'title' => 'nullable|string|max:255',
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
                'prompt' => $request->prompt,
                'conversation_id' => $request->conversation_id ?? 0,
                'ai_type' => $request->ai_type,
                'title' => $title,
            ]);

            if (!empty($validated['conversation_id']) && $validated['conversation_id'] > 0) {
                $conversation = ModelsConversation::where('id', $validated['conversation_id'])
                    ->where('user_id', $user->id)
                    ->first();

                if (!$conversation) {
                    throw new \Exception('Conversation not found.');
                }
            } else {
                $conversation = ModelsConversation::create([
                    'user_id' => $user->id,
                    'ai_type' => $validated['ai_type'] ?? '',
                    'title' => $validated['title'],
                ]);
            }


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

    public function clearConversation()
    {
        $user = User::getAuthenticatedUser();
        $conversation = ModelsConversation::where('user_id', $user->id)
            ->get();

        if (!$conversation) {
            return response()->json(['message' => 'Conversation not found'], 404);
        }
        $conversation->chats()->delete();
        $conversation->delete();
    }

    protected function generateTitleFromPrompt(string $prompt): string
    {
        $words = explode(' ', strip_tags($prompt));
        return ucfirst(implode(' ', array_slice($words, 0, 6))) . (count($words) > 6 ? '...' : '');
    }


    public function generateResume(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'summary' => 'nullable|string',
            'education' => 'array',
            'degree' => 'array',
            'years' => 'array',
            'company' => 'array',
            'position' => 'array',
            'job_description' => 'array',
            'skills' => 'nullable|string',
        ]);

        $prompt = $this->buildPrompt($data);
        $responseText = $this->gemini_service->sendPrompt($prompt);

        return array_merge($data, ['response' => $responseText]);
    }

    private function buildPrompt(array $data): string
    {
        return "You are an assistant for the resume generator. Generate resume for this:\n\n" .
            "Name: {$data['name']}\n" .
            "Email: {$data['email']}\n" .
            "Phone: {$data['phone']}\n" .
            "Summary: {$data['summary']}\n" .
            "Education: " . json_encode($data['education']) . "\n" .
            "Degree: " . json_encode($data['degree']) . "\n" .
            "Years: " . json_encode($data['years']) . "\n" .
            "Company: " . json_encode($data['company']) . "\n" .
            "Position: " . json_encode($data['position']) . "\n" .
            "Job Description: " . json_encode($data['job_description']) . "\n" .
            "Skills: {$data['skills']}";
    }
}
