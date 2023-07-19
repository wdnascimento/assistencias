<?php

namespace App\Http\Controllers\Auth\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    protected $redirectTo = '/professor';

    public function __construct()
    {
      $this->middleware('guest:professor')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('professor');
    }

    public function loginProfessor(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

        // Attempt to log the user in
      if (Auth::guard('professor')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('professor.home'));
      }
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => 'Usuário e senha não conferem']);
    }

    public function login(){
      $section = 'professor';
      return view('auth.login',compact('section'));
    }

    public function logout()
    {
        Auth::guard('professor')->logout();
        return redirect()->route('professor.auth.login');
    }


}
