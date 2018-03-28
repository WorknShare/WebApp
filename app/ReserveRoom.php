<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReserveRoom extends Model
{
  protected $primaryKey = "id_reserve_room";
  protected $table = 'reserve_room';
  public $timestamps = true;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'id_client','id_room', 'date_start', 'date_end',
  ];

  public function rooms()
  {
    return $this->belongsTo('App\Room', 'id_room');
  }

  public function equipments()
  {
    return $this->belongsToMany('App\Equipment', 'reserve_equipment', 'id_reserve_room', 'id_equipment');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'id_client');
  }

}
