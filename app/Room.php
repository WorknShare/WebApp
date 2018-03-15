<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $primaryKey = "id_room";
  public $timestamps = false;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'name','place',
  ];

  public function typeRoom()
  {
    return $this->belongsTo('App\TypeOfRoom', 'id_room_type');
  }

  public function reserve()
  {
    return $this->hasMany('App\ReserveRoom', 'id_room');
  }
}
