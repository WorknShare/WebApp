<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{

    protected $primaryKey = "id_site";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'wifi', 'drink',
    ];

	public function schedules()
	{
		return $this->hasMany('App\Schedule', 'id_site');
	}

  public function rooms()
  {
    return $this->hasMany('App\Room', 'id_site');
  }

  public function equipment()
  {
    return $this->hasMany('App\Equipment', 'id_site');
  }

  public function meals()
  {
    return $this->hasMany('App\Meal', 'id_meal');
  }
}
