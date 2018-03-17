<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class ResourceRepository
{

  protected $model;

  /**
   * Tells if the repository should use the soft deletion (database "is_deleted" column) behavior
   */
  protected $softDeleted = false;

  /**
   * Get the model this repository is using
   * 
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function getModel()
  {
    return $this->model;
  }

  /**
   * Get all the existing recordings.
   * 
   * @return array
   */
  public function getAll()
  {
    return $this->softDeleted ? $this->model->where('is_deleted','=',0) : $this->model->all();
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
    return $this->softDeleted ? $this->model->where('is_deleted','=',0)->orderBy($orderColumn,$order) : $this->model->all()->orderBy($orderColumn,$order);
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
    $search = '%'.strtolower($value).'%';
    if($this->softDeleted)
      return $this->model->whereRaw('LOWER('.$column.') LIKE ?', array($search))->andWhere('is_deleted','=',0)->take($limit)->get();
    else
      return $this->model->whereRaw('LOWER('.$column.') LIKE ?', array($search))->take($limit)->get();
  }

  /**
   * Get a single recording by its id.
   * 
   * @return model
   */
  public function getById($id)
  {
    return $this->softDeleted ? $this->model->where('is_deleted','=',0)->findOrFail($id) : $this->model->findOrFail($id);
  }

  /**
   * Get a paginate of the recordings.
   * 
   * @param int $n the amount of recordings per page
   * @return array
   */
  public function getPaginate($n)
  {
    return $this->softDeleted ? $this->model->where('is_deleted','=',0)->paginate($n) : $this->model->paginate($n);
  }

  /**
   * Get a paginate of the recordings with only selected columns.
   * 
   * @param int $n the amount of recordings per page
   * @param array $columns the columns to select with optional alias
   * @return array
   */
  public function getPaginateSelect($n, array $columns)
  {
    return $this->softDeleted ? $this->model->where('is_deleted','=',0)->select($columns)->paginate($n) : $this->model->select($columns)->paginate($n);
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
    return $this->softDeleted ? $this->model->where('is_deleted','=',0)->orderBy($orderColumn,$order)->paginate($n) : $this->model->orderBy($orderColumn,$order)->paginate($n);
  }

  /**
   * Get if a record exists with the given id
   * 
   * @param int $id
   * @return boolean
   */
  public function exists($id)
  {
    return $this->softDeleted ? $this->model->where($this->model->getKeyName(), $id)->andWhere('is_deleted','=',0)->exists() : $this->model->where($this->model->getKeyName(), $id)->exists();
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
    if($this->softDeleted)
    {
      $model = $this->getById($id);
      $model->is_deleted = true;
      $model->save();
    }
    else
      $this->getById($id)->delete();
  }

}
