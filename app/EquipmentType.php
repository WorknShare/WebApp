<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{

    protected $primaryKey = "id_equipment_type";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','id_deleted'
    ];

    public function equipment()
	{
		return $this->hasMany('App\Equipment', 'id_equipment_type');
	}
}
