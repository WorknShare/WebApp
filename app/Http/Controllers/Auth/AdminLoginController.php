<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
      $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
      return view('auth.login_admin');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required',
        'password' => 'required'
      ]);
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
      {

        // if successful, then redirect to their intended location
        return redirect()->intended(route('admin.home'));
      }

      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withErrors(["email"=>"Identifiants invalides"])->withInput($request->only('email', 'remember'));
    }
}
