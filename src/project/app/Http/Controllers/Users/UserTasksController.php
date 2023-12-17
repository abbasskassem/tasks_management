<?php

namespace App\Http\Controllers\Users;


use App\Core\BaseController;
use App\Core\BaseModel;
use App\Core\Helpers\ResponseHelper;
use App\Models\Tasks\Task;
use App\Services\Tasks\Actions\CreateTaskAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Response as HttpResponse;

class UserTasksController extends BaseController
{

    public function __construct(private readonly CreateTaskAction $createTaskAction)
    {

    }

    private function validateIfRequestingOwnResources(int $userId): void
    {

        if ($userId !== BaseModel::getAuthenticatedUserId())
        {
            throw new \Exception('ONLY_YOUR_RESOURCES_CAN_BE_REQUESTED');
        }
    }

    public function index(int $userId): JsonResponse
    {

        $this->validateIfRequestingOwnResources($userId);

        //we can optimize query here and select only what we really need ..
        $userTasks = Task::query()
                         ->forUser(BaseModel::getAuthenticatedUserId())
                         ->with('categories')
                         ->get();
        return ResponseHelper::success($userTasks);
    }

    public function store(int $userId, Request $request): JsonResponse
    {

        $this->validateIfRequestingOwnResources($userId);

        $input = $request->input();

        $rules = [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categories.*' => ['required', 'numeric', 'exists,categories,category_id']
        ];

        //WE CAN add more rules ..like confirm_password .. and should be identical ...
        $validator = Validator::make($input, $rules);

        $validator->validate();

        //ALSO we can validate that if its same password then we can return false...

        return ResponseHelper::successPost($this->createTaskAction->create($input));

    }


    public function update(int $userId, int $taskId, Request $request): JsonResponse
    {

        $this->validateIfRequestingOwnResources($userId);

        $request->request->add(['task_id' => $taskId]);
        $input = $request->input();


        $rules = [
            'task_id' => ['required', 'numeric', 'exists:tasks,task_id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categories.*' => ['required', 'numeric', 'exists:categories,category_id']
        ];

        //WE CAN add more rules ..like confirm_password .. and should be identical ...
        $validator = Validator::make($input, $rules);

        $validator->validate();

        //ALSO we can validate that if its same password then we can return false...

        return ResponseHelper::success($this->createTaskAction->update($taskId, $input));
    }


    public function delete(int $userId, int $taskId): JsonResponse
    {
        $this->validateIfRequestingOwnResources($userId);
        //WE Can send no content success response since its a delete request..
        return ResponseHelper::success(null, HttpResponse::HTTP_NO_CONTENT);
    }
}
