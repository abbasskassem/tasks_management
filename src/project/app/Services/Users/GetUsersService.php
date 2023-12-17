<?php

namespace App\Services\Users;


use App\Http\Resources\Users\UserResource;

use App\Models\Customers\Task;
use App\Models\Users\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class  GetUsersService
{

    public function __construct()
    {

    }

    public function all(): AnonymousResourceCollection
    {
        $users = User::query()
                     ->withGroupsAndRoles()
                     ->get();

        return UserResource::collection($users);
    }

    public function get(int $customerId): UserResource
    {
        $user = User::query()
                    ->with(['userTickets', 'tasks', 'categories'])
                    ->findOrFail($customerId);


        return new UserResource($user);
    }
}
