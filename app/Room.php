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

  public function room()
  {
    return $this->belongsTo('App\TypeOfRoom', 'id_room_type');
  }
}
