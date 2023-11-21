<?php

namespace App\Services;

use App\Contracts\TaskServiceInterface;
use App\Models\Task;
use App\Traits\BaseServiceRestoreTrait;


/**
 * Service class for managing tasks.
 */
class TaskService extends BaseService implements TaskServiceInterface
{
    use BaseServiceRestoreTrait;

    /**
     * Create a new TaskService instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    /**
     * @param $taskId
     * @param $userId
     * @return bool
     */
    public function assignTask($taskId, $userId): bool
    {
        $task = $this->getById($taskId);
        $task->user_id = $userId;
        return $task->save();
    }
}
