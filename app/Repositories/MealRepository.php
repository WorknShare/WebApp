<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Meal;


class MealRepository extends ResourceRepository
{

  protected $softDeleted = true;

	/**
     * Create a new repository instance.
     *
     * @param App\Meal $model
     * @return void
     */
  	public function __construct(Meal $model)
  	{
    	$this->model = $model;
  	}

	/**
     * Resource relative behavior for saving a record.
     *
     * @param Model $model
     * @param array $inputs
     * @return int id, the id of the saved resource
     */
     protected function save(Model $model, Array $inputs)
     {
       $model->name = $inputs['name'];
       $model->price = $inputs['price'];
       $model->menu = $inputs['menu'];

       $model->save();
       return $model->id_meal;
     }

}
