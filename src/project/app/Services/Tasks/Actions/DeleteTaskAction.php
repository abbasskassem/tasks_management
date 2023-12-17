<?php

namespace App\Services\Tasks\Actions;


use App\Models\Tasks\Task;

class DeleteTaskAction
{
    public function __construct()
    {

    }


    public function __invoke(int $taskId, array $payload): Task
    {


        $task = Task::query()
                    ->findOrFail($taskId);
        $task->delete();

        //TODO trigger Task Deleted Event ..

        return $task;
    }
}
