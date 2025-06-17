<?php

namespace App\Http\Resources\AI\V1\Assistant;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoAnalysesResource extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user' => [
                'user_id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'role' => $this->user->role,
            ],
            'title' => $this->title,
            'input_type' => $this->input_type,
            'url' => $this->url,
            'html_input' => $this->html_input,
            'prompt' => $this->prompt,
            'response' => $this->response,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
