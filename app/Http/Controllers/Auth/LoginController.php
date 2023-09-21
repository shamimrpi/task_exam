<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    public function login()
    {
       
      
        if (Auth::check()) {
            return redirect()->route('dashboard');
          } else {
            return view('auth.login');
          }
    }

    public function loginCheck(Request $request)
    {
        // dd($request->all());
       $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
       
  
      $credential = $request->only('email', 'password');
      if (Auth::attempt($credential)) {
        return redirect()->intended('/');
      } else {
        Session::flash('error', 'Opps! email or password not match');
        return redirect()->route('login');
      }
    }

    public function logout()
    {
      Auth::logout();
      return redirect()->route('login');
    }
}
