<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Plan;

class PlanRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param App\Plan $model 
     * @return void
     */
  	public function __construct(Plan $model)
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
        $model->description = $inputs['description'];
        $model->save();
		return $model->id_plan;
	}

}