<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'employees';
    protected $primaryKey = "id_employee";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'phone', 'address', 'changed_password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ticketsSource()
    {
        return $this->hasMany('App\Tickets', 'id_employee_src');
    }

    public function ticketsAssigned()
    {
        return $this->hasMany('App\Tickets', 'id_employee_assigned');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function generateApiToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
}
