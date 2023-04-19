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
    $remember = $request->filled("remember") == true ? true : false;
    $credentials = $request->validate([
      'username' => ['required'],
      'password' => ['required'],
    ]);

    if(Auth::viaRemember()) { //jika dia login menggunakan fitur remember maka arahkan langsung ke dashboard
      return redirect()->intended('/metal/dashboard');
    }

    if (Auth::attempt($credentials, $remember)) {//remember disimpan di database
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