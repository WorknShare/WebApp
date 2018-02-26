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

}
