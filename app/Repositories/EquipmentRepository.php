<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Equipment;

class EquipmentRepository extends ResourceRepository
{

    protected $softDeleted = true;

	/**
     * Create a new repository instance.
     *
     * @param \App\Equipment $model 
     * @return void
     */
  	public function __construct(Equipment $model)
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
		$model->serial_number = $inputs['serial_number'];
        $model->id_equipment_type = $inputs['id_equipment_type'];
        $model->save();
        return $model->id_equipment;
	}

}