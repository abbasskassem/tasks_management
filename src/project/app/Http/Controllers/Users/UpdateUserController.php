<?php

namespace App\Http\Controllers\Users;


use App\Core\BaseController;
use App\Core\BaseModel;
use App\Core\Helpers\ResponseHelper;
use App\Services\Users\Actions\UpdateUserAction;
use App\Services\Users\GetUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateUserController extends BaseController
{

    public function __construct(private readonly UpdateUserAction $updateUserAction)
    {

    }

    public function __invoke(int $userId, Request $request): JsonResponse
    {

        //JUST FOR DEMO SAKE ... to let you that we can force the user ID just to be the same logged in user in this case..
        //and this can be done on a higher level ..
        if($userId !== BaseModel::getAuthenticatedUserId()){
            throw new \Exception('ONLY_YOUR_PROFILE_CAN_BE_REQUESTED');
        }


        //WE CAN DO THE SAME FORM REQUEST and validators... before saving the data..

        return ResponseHelper::success($this->updateUserAction->update($userId, $request->input()));

    }
}
