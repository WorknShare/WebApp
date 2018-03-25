<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Model for plan payments
class Payment extends Model
{
    protected $primaryKey = "id_history";
    protected $table = "history";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'phone', 'address', 'city', 'postal', 'command_number', 'credit_card_number', 'csc', 'expiration', 'limit_date', 'id_plan', 'id_client'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'credit_card_number', 'csc', 'expiration'
    ];

    public function client()
	{
		return $this->belongsTo('App\User', 'client_history_plan', 'id_history', 'id_client');
	}

	public function plan()
	{
		return $this->belongsTo('App\Plan', 'client_history_plan', 'id_history', 'id_plan');
	}

	public function clientAndPlan()
	{
		return $this->client()->with('plan');
	}
}
