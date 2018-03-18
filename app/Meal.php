<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
  protected $primaryKey = "id_meal";
  public $timestamps = false;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'name','price', 'menu',
  ];

  public function site()
  {
    return $this->belongsTo('App\Site', 'id_site');
  }

}
