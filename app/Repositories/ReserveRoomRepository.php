<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\ReserveRoom;

class ReserveRoomRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param App\ReserveRoom $model
     * @return void
     */
  	public function __construct(ReserveRoom $model)
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
  	   $model->id_client = $input['id_client'];
       $model->id_room = $input['id_room'];
       $model->date_start = $input['date_start'];
       $model->date_end = $input['date_end'];
       $model->save();
  		 return $model->id_reserve_room;
  	}

}
