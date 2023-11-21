<?php

namespace App\Contracts;

interface CrudServiceInterface
{
    /**
     * Retrieve all instances of the model.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Create a new instance of the model.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Retrieve the specified instance of the model.
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Update the specified instance of the model.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete the specified instance of the model.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);
}
