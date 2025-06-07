<?php

namespace App\Http\Controllers;

use App\Models\Conversation as ModelsConversation;
use App\Models\User;
use App\Services\Chat\Conversation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GeminiController extends Controller
{
    protected $conversation_service;
    public function __construct()
    {
        $this->conversation_service = new Conversation();
    }

    public function showGeminiForm()
    {
        $user = User::getAuthenticatedUser();
        $conversations = ModelsConversation::with('chats')
            ->where('user_id', $user->id)
            ->where('ai_type', 'gemini')
            ->orderBy('created_at', 'asc')
            ->get();
        $chat_histories = [];
        foreach ($conversations as $conv) {
            foreach ($conv->chats as $chat) {
                $chat_histories[] = [
                    'sender' => $chat->sender,
                    'content' => $chat->content,
                ];
            }
        }
        return view('dashboard.chat.gemini.ask', [
            'chat_histories' => $chat_histories
        ]);
    }

    public function ask(Request $request)
    {

        try {
            $result = $this->conversation_service->createConversation($request);
            return response()->json([
                'prompt' => $result['prompt'],
                'response' => $result['response']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong. <a href="javascript:location.reload()">Click here to refresh the page</a>. If the error persists, please contact the developers.'
            ], 500);
        }
    }

    public function generateResumeForm()
    {
        return view('dashboard.chat.resume.create');
    }

    public function askForResume(Request $request)
    {
        try {
            $result = $this->conversation_service->generateResume($request);
            return response()->json([
                'full_response' => $result['response'],
                // 'name' => $result['name'],
                // 'email' => $result['email'],
                // 'phone' => $result['phone'] ?? '',
                // 'summary' => $result['summary'] ?? '',
                // 'skills' => $result['skills'] ?? '',
                // 'education' => $this->mapEducation($result),
                // 'experience' => $this->mapExperience($result),
                // 'full_response' => $result['response'] ?? '',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong.'], 500);
        }
    }

    private function mapEducation(array $result): array
    {
        return collect($result['education'] ?? [])->map(function ($school, $i) use ($result) {
            return [
                'school' => $school,
                'degree' => $result['degree'][$i] ?? '',
                'years' => $result['years'][$i] ?? '',
            ];
        })->toArray();
    }

    private function mapExperience(array $result): array
    {
        return collect($result['company'] ?? [])->map(function ($company, $i) use ($result) {
            return [
                'company' => $company,
                'position' => $result['position'][$i] ?? '',
                'description' => $result['job_description'][$i] ?? '',
            ];
        })->toArray();
    }
}
