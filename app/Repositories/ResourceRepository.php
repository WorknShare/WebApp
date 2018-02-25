<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class ResourceRepository
{

  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function getAll()
  {
    return $this->model->all();
  }

  public function getAllOrdered($orderColumn,$order)
  {
    return $this->model->all()->orderBy($orderColumn,$order);
  }

  public function getById($id)
  {
    return $this->model->findOrFail($id);
  }

  public function getPaginate($n)
  {
    return $this->model->paginate($n);
  }

  public function getPaginateOrdered($n,$orderColumn,$order)
  {
    return $this->model->orderBy($orderColumn,$order)->paginate($n);
  }

  protected abstract function save(Model $model, Array $inputs);

  public function store(Array $inputs)
  {
    $resource = new $this->model;

    $this->save($resource, $inputs);

    return $resource;
  }

  public function update($id, Array $inputs)
  {
    $this->getById($id)->update($inputs);
  }

  public function destroy($id)
  {
    $this->getById($id)->delete();
  }

}
