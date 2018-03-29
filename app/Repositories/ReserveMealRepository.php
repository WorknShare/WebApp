<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\ReserveMeal;

class ReserveMealRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param App\ReserveMeal $model
     * @return void
     */
  	public function __construct(ReserveMeal $model)
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
    $date = date_parse(date('Y-m-d H:i:s'));
    $command_number =  $date['year'].$date['month'].$date['day'].$date['hour'].$date['minute'].$date['second'].$inputs['id_client'].$inputs['id_site'];
    $model->command_number = $command_number;
    $model->id_client = $inputs['id_client'];
    $model->id_site = $inputs['id_site'];
    $date = $inputs['date'] . ' ' .$inputs['hour_start'];
    $model->hour = $date;
    $model->id_meal = $inputs['meal'];

    $model->save();

    return $model->id_reserve_room;
	}

}
