<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReserveMeal extends Model
{

  protected $primaryKey = 'id_order_meal';
  protected $table = 'client_meal_orders';
  public $timestamps = false;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'hour', 'command_number', 'id_client', 'id_site', 'id_meal',
  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'id_client');
  }
  
}
