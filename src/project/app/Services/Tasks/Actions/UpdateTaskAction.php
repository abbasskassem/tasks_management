<?php

namespace App\Services\Tasks\Actions;


use App\Models\Tasks\Task;

class UpdateTaskAction
{
    public function __construct()
    {

    }


    public function __invoke(int $taskId, array $payload): Task
    {


        $task = Task::query()
                    ->findOrFail($taskId);
        $task->fill($payload);
        $task->saveOrFail();

        //TODO trigger task updated event ..
        return $task;

    }
}
