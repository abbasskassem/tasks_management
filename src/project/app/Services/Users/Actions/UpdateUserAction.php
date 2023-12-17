<?php

namespace App\Services\Users\Actions;


use App\Http\Resources\Users\UserResource;
use App\Models\Customers\Task;
use App\Models\Users\User;

use Illuminate\Support\Facades\Hash;

class  UpdateUserAction
{

    public function __construct()
    {

    }

    public function update(int $userId, array $payload): UserResource
    {

        $user = User::query()
                    ->findOrFail($userId);

        //SURE WE CAN MAKE A VALIDATOR to prevent sending password in the payload..
        //but just for safety..
        if (isset($payload['password']))
        {
            unset($payload['password']);
        }


        $user->fill($payload);
        $user->saveOrFail();

        //CREATE NEW UserCreatedEvent ..

        return new UserResource($user);

    }

    public function updatePassword(int $userId, string $newPassword): UserResource
    {
        $user = User::query()
                    ->findOrFail($userId);
        $user->password = Hash::make($newPassword);
        $user->saveOrFail();

        //NOTIFY ABOUT SUCCESSFULL PASSWORD CHANGE ..

        return new UserResource($user);
    }
}
