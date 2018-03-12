<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    
    protected $primaryKey = "id_equipment";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_number', 'id_equipment_type',
    ];

    public function type()
	{
		return $this->belongsTo('App\EquipmentType', 'id_equipment_type');
	}

    public function site()
    {
        return $this->belongsTo('App\Site', 'id_site');
    }

}
