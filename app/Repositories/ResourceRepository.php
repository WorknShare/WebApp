<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class ResourceRepository
{

  protected $model;

  /**
   * Get all the existing recordings.
   * 
   * @return array
   */
  public function getAll()
  {
    return $this->model->all();
  }

  /**
   * Get all the existing recordings ordered according to the given column.
   * 
   * @param string $orderColumn
   * @param string $order (ex.: 'asc', 'desc')
   * @return array
   */
  public function getAllOrdered($orderColumn,$order)
  {
    return $this->model->all()->orderBy($orderColumn,$order);
  }

  /**
   * Get the recordings matching the given WHERE clause
   * 
   * @param string $column
   * @param $value
   * @param int $limit
   * @return array
   */
  public function getWhere($column,$value,$limit=100)
  {
    $search = '%'.$value.'%';
    return $this->model->whereRaw("LOWER(?) LIKE LOWER(?)",array($column,$search));
  }

  /**
   * Get a single recording by its id.
   * 
   * @return model
   */
  public function getById($id)
  {
    return $this->model->findOrFail($id);
  }

  /**
   * Get a paginate of the recordings.
   * 
   * @param int $n the amount of recordings per page
   * @return array
   */
  public function getPaginate($n)
  {
    return $this->model->paginate($n);
  }

  /**
   * Get a paginate of the recordings ordered according to the given column.
   * 
   * @param int $n the amount of recordings per page
   * @param string $orderColumn
   * @param string $order (ex.: 'asc', 'desc')
   * @return array
   */
  public function getPaginateOrdered($n,$orderColumn,$order)
  {
    return $this->model->orderBy($orderColumn,$order)->paginate($n);
  }

  /**
   * Resource relative behavior for saving a record.
   * 
   * @param Model $model
   * @param array $inputs
   * @return int id, the id of the saved resource
   */
  protected abstract function save(Model $model, Array $inputs);

  /**
   * Create and save a new record from the inputs.
   *
   * @param array $inputs
   * @return Model resource, the generated record
   */
  public function store(Array $inputs)
  {
    $resource = new $this->model;

    $this->save($resource, $inputs);

    return $resource;
  }

  /**
   * Update a record
   *
   * @param int $id, the id of the record to update
   * @param array $inputs
   * @return void
   */
  public function update($id, Array $inputs)
  {
    $this->getById($id)->update($inputs);
  }

  /**
   * Delete a record
   *
   * @return void
   */
  public function destroy($id)
  {
    $this->getById($id)->delete();
  }

}
