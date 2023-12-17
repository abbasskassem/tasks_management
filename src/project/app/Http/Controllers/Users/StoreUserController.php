<?php

namespace App\Http\Controllers\Users;


use App\Core\BaseController;
use App\Core\Helpers\ResponseHelper;
use App\Http\Requests\StoreUserRequest;
use App\Services\Users\Actions\CreateUserAction;
use Illuminate\Http\JsonResponse;


class StoreUserController extends BaseController
{

    public function __construct(private readonly CreateUserAction $createUserAction)
    {
    }

    public function __invoke(StoreUserRequest $storeUserRequest): JsonResponse
    {
        return ResponseHelper::successPost($this->createUserAction->create($storeUserRequest->input()));
    }
}
