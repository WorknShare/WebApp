<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    
    protected $primaryKey = "id_schedule";
    protected $table = "site_schedules";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day', 'hour_opening', 'hour_closing',
    ];

    public function site()
	{
		return $this->belongsTo('App\Site', 'id_site');
	}
}
