<?php
namespace App\Services;
use App\Contracts\CrudServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Abstract base service class for common CRUD operations.
 */
abstract class BaseService implements CrudServiceInterface
{
    /**
     * The model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * Create a new service instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all instances of the model.
     *
     * @return Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Create a new instance of the model.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Retrieve the specified instance of the model.
     *
     * @param int $id
     * @return Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update the specified instance of the model.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data)
    {
        $item = $this->getById($id);
        $item->update($data);
        return $item;
    }

    /**
     * Delete the specified instance of the model.
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $item = $this->getById($id);
        $item->delete();
    }
}
