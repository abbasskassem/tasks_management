<?php

namespace App\Http\Controllers\Tasks;

use App\Core\Helpers\ResponseHelper;
use App\Core\BaseController;
use App\Services\Customers\TasksService;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class TasksController extends BaseController
{


    public function __construct(protected readonly TasksService $customersService)
    {
    }


    public function show(int $taskId): JsonResponse
    {
        $input = ['task_id' => $taskId];

        $rules = [
            'task_id' => 'required|numeric|exists:tasks,task_id'
        ];

        $validator = Validator::make($input, $rules);

        $validator->validate();


        return ResponseHelper::success($this->customersService->getCustomer($customerId));
    }
}
