<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
  * Handle an authentication attempt.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function login() {
    if(Auth::check()) {
      return redirect("/metal/dashboard");
    }
    return view("admin.login");
  }
  public function authenticate(Request $request) {
    $credentials = $request->validate([
      'username' => ['required'],
      'password' => ['required'],
    ]);
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended('/metal/dashboard');
    }
    return back()->withInput()->with('invalid', "Username / Password salah");
  }
  public function index() {
    return view("admin.index");
  }
  public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/metal');
    
  }
}