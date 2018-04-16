<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    
	protected $primaryKey = "id_ticket";

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'description', 'created_at', 'updated_at',
    ];

    public function employeeSource()
	{
		return $this->belongsTo('App\Employee', 'id_employee_src');
	}

	public function employeeAssigned()
	{
		return $this->belongsTo('App\Employee', 'id_employee_assigned');
	}

	public function equipment()
	{
		return $this->belongsTo('App\Equipment', 'id_equipment');
	}

}
