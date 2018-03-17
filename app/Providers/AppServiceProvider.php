<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Employee;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('match', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, $parameters[0]);
        });
        Validator::extend('least', function ($attribute, $value, $parameters, $validator) {
            $employee = Employee::find($parameters[0]);
            return $value == $parameters[1] || DB::table('employees')->where($attribute, '=', $parameters[1])->count()-($employee->role == $parameters[1] ? 1 : 0) >= 1;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
