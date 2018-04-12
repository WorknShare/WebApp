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

    public function login(Request $request)
    {
      $this->validateLogin($request);

      if ($this->hasTooManyLoginAttempts($request))
      {
          $this->fireLockoutEvent($request);
          return $this->sendLockoutResponse($request);
      }

      if ($this->attemptLogin($request)) {

          $employee = $this->guard()->user();

          if(!$employee->changed_password)
            return response()->json([
              'errors' => [
                "email" => "Veuillez vous connecter sur le site pour modifier votre mot de passe."
              ]
            ], 403);

          $employee->generateApiToken();

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
