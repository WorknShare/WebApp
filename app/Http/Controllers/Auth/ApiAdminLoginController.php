<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;

class ApiAdminLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
      $this->middleware('guest:admin-api')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin-api');
    }

    public function login()
    {
      $this->validateLogin($request);

      if ($this->hasTooManyLoginAttempts($request))
      {
          $this->fireLockoutEvent($request);
          return $this->sendLockoutResponse($request);
      }

      if ($this->attemptLogin($request)) {
          $employee = $this->guard()->user();
          $employee->generateToken();

          return response()->json([
              'data' => $employee->toArray(),
          ]);
      }

      $this->incrementLoginAttempts($request);

      return $this->sendFailedLoginResponse($request);
    }

    public function logout()
    {
      
      $employee = Auth::guard('admin-api')->user();

      if ($employee) {
          $employee->api_token = null;
          $employee->save();
      }

      return response()->json(['data' => 'User logged out.'], 200);
    }
}
