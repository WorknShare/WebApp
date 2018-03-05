<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Schedule;

class ScheduleRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param App\Schedule $model 
     * @return void
     */
  	public function __construct(Schedule $model)
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
		$model->id_site = $inputs['id_site'];
        $model->day = $inputs['day'];
        $model->hour_opening = $inputs['hour_opening'];
        $model->hour_closing = $inputs['hour_closing'];
        $model->save();
		return $model->id_schedule;
	}

}