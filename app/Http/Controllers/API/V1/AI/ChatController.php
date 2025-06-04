<?php

namespace App\Http\Controllers\API\V1\AI;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AI\V1\ChatResource;
use App\Models\Conversation as ModelsConversation;
use App\Models\User;
use App\Services\Chat\Conversation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ChatController extends Controller
{
    protected $conversation_service;
    public function __construct()
    {
        $this->conversation_service = new Conversation();
    }

    public function getUserConversation()
    {
        try {
            $user = User::getAuthenticatedUser();
            $conversations = ModelsConversation::with('chats')
                ->where('user_id', $user->id)->latest()
                ->get();

            if ($conversations->isEmpty()) {
                return [];
            }

            return ApiHelper::successResponse('User conversations fetched successfully', [
                'conversations' => $conversations,
            ]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    public function getConversationMessages($uuid_id)
    {
        try {
            $user = User::getAuthenticatedUser();
            $conversation = ModelsConversation::with('chats')
                ->where('uuid', $uuid_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$conversation) {
                return ApiHelper::errorResponse('Conversation not found', 404);
            }

            return ApiHelper::successResponse('Conversation messages fetched successfully', [
                'conversation' => $conversation,
            ]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }


    public function ask(Request $request)
    {
        try {
            $result = $this->conversation_service->createConversation($request);
            $chats = ChatResource::collection(
                $result['conversation']->chats()->with('conversation.user')->get()
            );

            return ApiHelper::successResponse('Conversation created successfully', [
                'prompt' => $result['prompt'],
                'response' => $result['response'],
                'chats' => $chats,
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return ApiHelper::validationErrorResponse($errors);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong. If the error persists, please contact the developers.' . $e->getMessage(), 401);
        }
    }

    public function clearConversation($uuid)
    {
        try {
            $this->conversation_service->clearConversation($uuid);
            return ApiHelper::successResponse('Conversation cleared successfully');
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    public function clearConversations()
    {
        try {
            $user = User::getAuthenticatedUser();
            $conversations =  $this->conversation_service->clearConversations();
            return ApiHelper::successResponse('Conversations cleared successfully', [
                'conversation' => $conversations,
            ]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
