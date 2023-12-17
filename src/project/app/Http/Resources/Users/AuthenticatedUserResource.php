<?php

namespace App\Http\Resources\Users;

use App\Core\BaseResource;
use Illuminate\Http\Request;

class AuthenticatedUserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->token,
            'user' => [
                'public_id' => $this->public_user_id,
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
            ],
        ];
    }
}
