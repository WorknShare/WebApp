<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\EquipmentType;

class EquipmentTypeRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param \App\EquipmentType $model 
     * @return void
     */
  	public function __construct(EquipmentType $model)
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
        $model->save();
        return $model->id_equipment_type;
	}

}