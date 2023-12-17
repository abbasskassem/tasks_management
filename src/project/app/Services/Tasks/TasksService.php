<?php

namespace App\Services\Tasks;


use App\Http\Resources\CustomerResource;
use App\Models\Customers\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class  TasksService
{

    public function __construct()
    {

    }

    public function createNewTask(array $taskPayload): Task
    {



    }

    public function getTask(int $taskId): CustomerResource
    {
        $customer = Task::query()
                        ->findOrFail($customerId);


        return new CustomerResource($customer);
    }
}
