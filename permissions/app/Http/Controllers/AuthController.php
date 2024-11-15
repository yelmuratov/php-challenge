<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            return redirect('/')->withSuccess('You have successfully logged in.');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        $user = User::create($request->only('name', 'email') + [
            'password' => bcrypt($request->password),
        ]);
        auth()->login($user);
        return redirect('/login')->withSuccess('You have registered successfully.');
    }

    public function logout() {
        if(auth()->check()) {
            auth()->logout();
            return redirect('/login')->withSuccess('You have logged out successfully.');
        }else{
            return redirect('/login');
        }
    }
}
