<?php

namespace App\Http\Resources\AI\V1\Assistant;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoAnalyzerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user =  User::getAuthenticatedUser();
        return [
            'user' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'title' => $this->resource['title'] ?? null,
            'prompt' => $this->resource['prompt'] ?? null,
            'response' => $this->resource['response'] ?? null,
            'raw_response' => $this->resource['raw_response'] ?? null,
        ];
    }
}
