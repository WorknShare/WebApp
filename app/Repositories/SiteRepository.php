<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Site;

class SiteRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param App\Site $model 
     * @return void
     */
  	public function __construct(Site $model)
  	{
    	$this->model = $model;
  	}

	/**
     * Resource relative behavior for saving a record.
     * 
     * @param Site $model
     * @param array $inputs
     * @return int id, the id of the saved resource
     */
	protected function save(Model $model, Array $inputs)
	{
		$model->name = $inputs['name'];
		$model->address = $inputs['address'];
		$model->wifi = isset($inputs['wifi']);
		$model->drink = isset($inputs['drink']);
		$model->save();
		return $model->id_site;
	}

}