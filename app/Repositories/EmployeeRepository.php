<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Employee;

class EmployeeRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param \App\Employee $model 
     * @return void
     */
  	public function __construct(Employee $model)
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
        $model->surname = $inputs['surname'];
        $model->email = $inputs['email'];
        $model->phone = $inputs['phone'];
        $model->address = $inputs['address'];
        $model->role = $inputs['role'];
        if(isset($inputs['password'])) $model->password = $inputs['password'];
        $model->save();
        return $model->id_client;
	}

}