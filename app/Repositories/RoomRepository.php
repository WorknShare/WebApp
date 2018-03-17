<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Room;

class RoomRepository extends ResourceRepository
{
  protected $softDeleted = true;
  /**
  * Create a new repository instance.
  *
  * @param App\Room $model
  * @return void
  */
  public function __construct(Room $model)
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
    $model->place = $inputs['place'];
    $model->name = $inputs['name'];
    $model->id_room_type = $inputs['id_room_type'];
    $model->save();
    return $model->id_room;
  }

}
