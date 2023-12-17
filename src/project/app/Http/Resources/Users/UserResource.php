<?php

namespace App\Http\Resources\Users;

use App\Core\BaseResource;
use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'public_id' => $this->public_user_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'nationality_id' => $this->nationality_id,

            //JUST TO SHOW what we can do we resources ..
            'categories' => $this->whenLoaded('categories', function ()
            {
                return $this->categories->toArray();
            }),

            'tickets' => $this->whenLoaded('tickets', function ()
            {
                return $this->tickets->toArray();
            }),

            'tasks' => $this->whenLoaded('tasks', function ()
            {
                return $this->tasks->toArray();
            }),

        ];
    }
}
