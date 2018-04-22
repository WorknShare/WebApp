<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\ReserveRoom;

class ReserveRoomRepository extends ResourceRepository
{
    protected $softDeleted = true;
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

       $date = date_parse(date('Y-m-d H:i:s'));
       $command_number =  $date['year'].$date['month'].$date['day'].$date['hour'].$date['minute'].$date['second'].$inputs['id_client'].$inputs['id_room'];
       $model->command_number = $command_number;
  	   $model->id_client = $inputs['id_client'];
       $model->id_room = $inputs['id_room'];

       $date_start = $inputs['date'] . ' ' .$inputs['hour_start'];
       $model->date_start = $date_start;

       $date_end = $inputs['date'] . ' ' . $inputs['hour_end'];
       $model->date_end = $date_end;
       $model->save();

       $model->equipments()->detach();
       
       if(!empty($inputs['equipments']))
       {
           foreach($inputs['equipments'] as $id_equipment)
           {
               $model->equipments()->attach($id_equipment);
           }
       }


  		 return $model->id_reserve_room;
  	}

}
