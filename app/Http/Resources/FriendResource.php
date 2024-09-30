<?php

namespace App\Http\Resources;

use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'friend_id' => $this->friend_id,
            'user_id' => $this->user_id,
            'name' => Passenger::where('user_id', $this->friend_id)->first()->name ?? null,
            'profile_image' => Passenger::where('user_id', $this->friend_id)->first()->profile_image ?? null,
            'email' => User::find($this->friend_id)->email ?? null
        ];
    }
}
