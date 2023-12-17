<?php

namespace App\Services\Tasks\Actions;


use App\Core\BaseModel;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskCategory;
use Carbon\Carbon;


class CreateTaskAction
{
    public function __construct()
    {

    }


    public function create(array $payload): Task
    {


        $task = new Task();
        $task->fill($payload);
        $task->saveOrFail();


        //WE CAN OPTIMIZE THIS FOR SURE ...
        if (isset($payload['categories']) && is_array($payload['categories']))
        {
            $this->fillTaskCategories($task, $payload);
        }

        //TODO we can here go more beyond this... triggerring event about new task created ..
        //THIS event can have many different purpose listeners ..
        //for example send user success email creation ..
        //inform admin about new task creation..

        return $task->fresh();

    }

    public function update(int $taskId, array $payload): Task
    {

        $userID = BaseModel::getAuthenticatedUserId();
        //WE ensure here that user is only editing his own task...
        $task = Task::query()
                    ->forUser($userID)
                    ->findOrFail($taskId);

        $task->fill($payload);


        //WE CAN OPTIMIZE THIS FOR SURE ...
        if (isset($payload['categories']) && is_array($payload['categories']))
        {
            TaskCategory::query()
                        ->forTask($taskId)
                        ->delete();
            $this->fillTaskCategories($task, $payload);
        }
        else
        {

            //THIS should be based on business rules ..do we consider empty cateogires deleting them ? ..
            // $task->categories->delete();
        }


        $task->updateOrFail();


        return Task::query()
                   ->with('categories')
                   ->find($taskId);
    }


    private function fillTaskCategories(Task $task, array $payload): void
    {

        if (!isset($payload['categories']) || !is_array($payload['categories']) || empty($payload['categories']))
        {
            return;
        }

        //WE CAN OPTIMIZE THIS FOR SURE ...

        $taskCategories = [];

        $createdByUserID = BaseModel::getAuthenticatedUserId();
        $nowDateTime = Carbon::now()
                             ->toDateTimeString();

        foreach ($payload['categories'] as $taskCategoryId)
        {
            //SINCE we are using insert ..create_by and updated by that can be filled automatically once user save() or update ..will not work since boot()
            // model is not being called in insert..and its a normal insert query..
            $taskCategories[] = ['task_id' => $task->task_id, 'category_id' => $taskCategoryId, 'created_by' => $createdByUserID, 'created_at' => $nowDateTime];
        }

        if (!empty($taskCategories))
        {
            TaskCategory::insert($taskCategories);
        }

    }

    public function delete(int $taskId): bool
    {
        $userID = BaseModel::getAuthenticatedUserId();
        //WE ensure here that user is only editing his own task...
        $task = Task::query()
                    ->forUser($userID)
                    ->findOrFail($taskId);


        TaskCategory::query()
                    ->forTask($taskId)
                    ->delete();
        $task->deleteOrFail();
        return true;
    }
}
