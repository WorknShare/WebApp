<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAdvantage extends Model
{
    protected $primaryKey = "id_plan_advantage";
    //protected $table = "plan_advantages";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
    ];

    public function plans()
	{
		return $this->belongsToMany('App\Plan', 'plan_has_advantage', 'id_plan', 'id_plan_advantage');
	}
}
