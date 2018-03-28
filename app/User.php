<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $primaryKey = "id_client";
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'tokenQrCode', 'is_deleted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan', 'id_plan');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment', 'id_client');
    }

    public function lastPayment()
    {
        return $this->payments()->latest()->first();
    }

    public function reserves()
    {
      return $this->hasMany('App\ReserveRoom', 'id_client');
    }
}
