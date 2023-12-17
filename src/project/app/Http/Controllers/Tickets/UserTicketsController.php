<?php

namespace App\Http\Controllers\Tickets;


use App\Core\BaseController;
use App\Core\BaseModel;
use App\Core\Helpers\ResponseHelper;
use App\Models\Tasks\Task;
use App\Models\Users\UserTicket;
use App\Services\Tasks\Actions\CreateTaskAction;
use App\Services\Tickets\TicketingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Response as HttpResponse;

class UserTicketsController extends BaseController
{

    public function __construct(private readonly TicketingService $ticketingService)
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

        return ResponseHelper::success($this->ticketingService->getUserTickets($userId));
    }

    public function store(int $userId, Request $request): JsonResponse
    {

        $this->validateIfRequestingOwnResources($userId);

        $input = $request->input();

        $rules = [
            'task_id' => ['required', 'exists:tasks,task_id'],
            'user_id' => ['required', 'exists:users,user_id'],
            'due_date' => ['required', 'date', 'after:yesterday'],
        ];

        //CAN I assign ticket to my self??
        //IF NO we should check the user_id if same as the current login..

        //THOSE can be moved to the function
        $input['assigner_user_id'] = $userId;
        $input['status'] = UserTicket::STATUS_PENDING;
        $input['assignment_datetime'] = Carbon::now()
                                              ->toDateTimeString();

        //WE CAN add more rules ..like confirm_password .. and should be identical ...
        $validator = Validator::make($input, $rules);

        $validator->validate();

        //ALSO we can validate that if its same password then we can return false...

        return ResponseHelper::successPost($this->ticketingService->assignTicketToUser($input));

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
