<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait BaseServiceRestoreTrait
{
    /**
     * Restore a soft deleted model instance by its primary key.
     *
     * @param int $id The primary key of the model to restore.
     * @return bool|null
     *
     * @throws ModelNotFoundException
     */
    public function restore($id)
    {
        $model = $this->model->onlyTrashed()->find($id);

        if (!$model) {
            throw new ModelNotFoundException("No query results for model [{$this->model->getName()}] with id {$id}");
        }

        return $model->restore();
    }

    /**
     * Permanently delete a soft deleted model instance by its primary key.
     *
     * @param int $id The primary key of the model to delete.
     * @return void
     *
     * @throws ModelNotFoundException
     */
    public function forceDelete($id)
    {
        $model = $this->model->withTrashed()->find($id);

        if (!$model) {
            throw new ModelNotFoundException("No query results for model [{$this->model->getName()}] with id {$id}");
        }

        $model->forceDelete();
    }

}
