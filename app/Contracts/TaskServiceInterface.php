<?php

namespace App\Contracts;

interface TaskServiceInterface  extends CrudServiceInterface
{

    /**
     * Restore the soft deleted instance of the model.
     *
     * @param int $id
     * @return mixed
     */
    public function restore($id);

    /**
     * Permanently delete the soft deleted instance of the model.
     *
     * @param int $id
     * @return mixed
     */
    public function forceDelete($id);

    /**
     * Assign task to User by userId
     *
     * @param $taskId
     * @param $userId
     * @return mixed
     */
    public function assignTask($taskId, $userId);
}
