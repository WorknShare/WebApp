<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomTypes extends Model
{
  protected $primaryKey = "id_room_type";
public $timestamps = false;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'name',
  ];

  public function room()
  {
    return $this->hasMany('App\Room', 'id_room');
  }
}
