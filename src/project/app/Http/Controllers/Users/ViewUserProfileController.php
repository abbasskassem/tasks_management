<?php

namespace App\Http\Controllers\Users;


use App\Core\BaseController;
use App\Core\BaseModel;
use App\Core\Helpers\ResponseHelper;
use App\Services\Users\GetUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ViewUserProfileController extends BaseController
{

    public function __construct(private readonly GetUsersService $getUsersService)
    {

    }

    public function __invoke(int $userId): JsonResponse
    {


        $input = ['user_id' => $userId];
        $rules = ['user_id' => ['required', 'numeric', 'exists:users,user_id']];
        $validator = Validator::make($input, $rules);

        $validator->validate();



        //JUST FOR DEMO SAKE ... to let you that we can force the user ID just to be the same logged in user in this case..
        if($userId !== BaseModel::getAuthenticatedUserId()){
            throw new \Exception('ONLY_YOUR_PROFILE_CAN_BE_REQUESTED');
        }


        return ResponseHelper::success($this->getUsersService->get($userId));
    }
}
