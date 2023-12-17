<?php

namespace App\Services\Users\Actions;


use App\Http\Resources\Users\UserResource;
use App\Models\Customers\Task;
use App\Models\Users\User;

use Illuminate\Support\Facades\Hash;

class  CreateUserAction
{

    public function __construct()
    {

    }

    public function create(array $payload): UserResource
    {

        $user = new User();


        $user->fill($payload);

        $user->password = Hash::make($payload['password']);
        $user->saveOrFail();

        //CREATE NEW UserCreatedEvent ..

        return new UserResource($user);

    }
}
