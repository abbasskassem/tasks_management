<?php

namespace App\Services\Users\Actions;


use App\Core\Helpers\JWTTokenHelper;
use App\Events\UserLoggedInEvent;
use App\Http\Resources\Users\AuthenticatedUserResource;
use App\Http\Resources\Users\UserResource;


use App\Models\Users\GroupRole;
use App\Models\Users\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

class  AuthUsersService
{

    public function __construct()
    {

    }

    public function login(string $email, #[SensitiveParameter] string $password): AuthenticatedUserResource
    {

        $user = User::query()
                    ->forEmail($email)
                    ->firstOrFail();


        if (Hash::check($password, $user->password) === false)
        {
            throw new UnauthorizedException('WRONG_USER_NAME_OR_PASSWORD');
        }

        if($user->is_active !== 1){
            //LOG inactive user is trying to login to the system ..
            throw new UnauthorizedException('WRONG_USER_NAME_OR_PASSWORD');
        }

        $key = $user->user_id . $user->public_user_id . Carbon::now()
                                                              ->toDayDateTimeString() . Str::random(10);
        $keyHashed = Hash::make($key);

        $tokenPayload = JWTTokenHelper::prepareJwtPayload($keyHashed, []);

        $token = JWTTokenHelper::encode($tokenPayload);

        $user->token = $token;

        //WE CAN DO SOMETHING LIKE THIS ....
        // $user->userCreatedTasks = \App\Models\Tasks\Task::query()
        //                             ->select(['task.task_id', 'task.title','categories.name'])
        //                             ->join('task_categories', function ($join)
        //                             {
        //                                 $join->on('task_categories.task_id', '=', 'tasks.task_id');
        //                             })
        //                             ->join('categories', 'task_categories.category_id', '=', 'categories.category_id')
        //                             ->where('task.created_by', $user->user_id)
        //
        //                             ->get()
        //
        //                             ->pluck('role_id')
        //                             ->toArray();

        $user->with(['categories','tasks']);


        //TRIGGER EVENT LOGGED IN USER
        event(new  UserLoggedInEvent($user));
        return new AuthenticatedUserResource($user);
    }

    public function authenticateByToken(string $bearerToken): UserResource
    {


    }
}
