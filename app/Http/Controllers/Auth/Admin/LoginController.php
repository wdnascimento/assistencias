<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    //

    protected $redirectTo = '/admin';

    public function __construct()
    {
      $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function loginAdmin(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('admin.home'));
      }
      // if unsuccessful, then redirect back to the login with the form data



      return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => 'Usuário e senha não conferem']);
    }

    public function login(){
      $section = 'admin';
      return view('auth.login',compact('section'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }


}
