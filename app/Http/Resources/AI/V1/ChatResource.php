<?php

namespace App\Http\Resources\AI\V1;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->conversation->user), 
            'id' => $this->id,
            'message' => $this->content,
            'created_at' => $this->created_at,
        ];
    }
}
