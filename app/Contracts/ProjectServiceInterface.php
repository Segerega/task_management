<?php

namespace App\Contracts;

interface ProjectServiceInterface extends CrudServiceInterface
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
     * Get Project Statistics
     *
     * @return mixed
     */
    public function getStatistics($userId);
}
