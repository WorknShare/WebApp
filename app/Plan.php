<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $primaryKey = "id_plan";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','price','notes','order_meal','reserve'
    ];

    public function advantages()
	{
		return $this->belongsToMany('App\PlanAdvantage', 'plan_has_advantage', 'id_plan', 'id_plan_advantage');
	}

    public function users()
    {
        return $this->hasMany('App\User', 'id_plan');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment', 'id_history');
    }
}
