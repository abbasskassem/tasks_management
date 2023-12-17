<?php

namespace App\Http\Controllers\Users;


use App\Core\BaseController;
use App\Core\Helpers\ResponseHelper;
use App\Http\Requests\LoginUserRequest;
use App\Services\Users\Actions\AuthUsersService;

use Illuminate\Http\JsonResponse;


class LoginUserController extends BaseController
{

    public function __construct(private readonly AuthUsersService $authUsersService)
    {

    }

    public function __invoke(LoginUserRequest $loginUserRequest): JsonResponse
    {

        return ResponseHelper::success($this->authUsersService->login($loginUserRequest->input('email'), $loginUserRequest->input('password')));
    }
}
