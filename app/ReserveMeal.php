<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reserveMeal extends Model
{
  protected $primaryKey = [
    'id_client', 'id_site', 'id_meal'
  ];
  protected $table = 'client_meal_orders';
  public $timestamps = false;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'id_site', 'hour',
  ];


}
