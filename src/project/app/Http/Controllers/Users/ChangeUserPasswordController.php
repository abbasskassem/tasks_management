<?php

namespace App\Http\Controllers\Users;


use App\Core\BaseController;
use App\Core\BaseModel;
use App\Core\Helpers\ResponseHelper;
use App\Services\Users\Actions\UpdateUserAction;
use App\Services\Users\GetUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangeUserPasswordController extends BaseController
{

    public function __construct(private readonly UpdateUserAction $updateUserAction)
    {

    }

    public function __invoke(int $userId, Request $request): JsonResponse
    {

        //JUST FOR DEMO SAKE ... to let you that we can force the user ID just to be the same logged in user in this case..
        //and this can be done on a higher level ..
        if ($userId !== BaseModel::getAuthenticatedUserId())
        {
            throw new \Exception('ONLY_YOUR_PROFILE_CAN_BE_REQUESTED');
        }


        $input = $request->input();

        $rules = ['password' => ['required', 'min:10', 'max:18']];

        //WE CAN add more rules ..like confirm_password .. and should be identical ...
        $validator = Validator::make($input, $rules);

        $validator->validate();

        //ALSO we can validate that if its same password then we can return false...

        return ResponseHelper::success($this->updateUserAction->update($userId, $request->input('password')));

    }
}
