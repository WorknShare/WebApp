<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    public function __construct()
    {
      $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
      return view('auth.login_admin');
    }

    public function login(Request $request)
    {

      $this->validateLogin($request);

      //Disconnect from normal user session if connected as such
      if(Auth::guard('web')->check())
      {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
      }

      if ($this->hasTooManyLoginAttempts($request))
      {
          $this->fireLockoutEvent($request);
          return $this->sendLockoutResponse($request);
      }

      if ($this->attemptLogin($request))
      {
          if($this->guard()->user()->is_deleted)
          {
              $this->guard()->logout();
              return redirect('admin/login')->withErrors([$this->username() => "Votre compte est désactivé"]);
          } else return $this->sendLoginResponse($request);
      }

      $this->incrementLoginAttempts($request);

      return $this->sendFailedLoginResponse($request);
    }
}
