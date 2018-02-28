<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param App\User $model
     * @return void
     */
  	public function __construct(User $model)
  	{
    	$this->model = $model;
  	}

	/**
     * Resource relative behavior for saving a record.
     *
     * @param User $model
     * @param array $inputs
     * @return int id, the id of the saved resource
     */
	protected function save(Model $model, Array $inputs)
	{
    $model->name = $inputs['name'];
		$model->surname = $inputs['surname'];
		$model->email = isset($inputs['email']);
		$model->password = isset($inputs['password']);
		$model->save();
		return $model->id_client;
	}

}
