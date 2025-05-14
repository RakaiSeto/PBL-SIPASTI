<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helper\Helper;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role->role_nama == 'Admin') {
                return redirect('/admin/dashboard');
            } else if (Auth::user()->role->role_nama == 'Teknisi') {
                return redirect('/teknisi/dashboard');
            } else if (Auth::user()->role->role_nama == 'Civitas') {
                return redirect('/civitas');
            }
        }

        return view('auth.login');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role->role_nama == 'Admin') {
                return redirect('/admin/dashboard');
            } else if (Auth::user()->role->role_nama == 'Teknisi') {
                return redirect('/teknisi/dashboard');
            } else if (Auth::user()->role->role_nama == 'Civitas') {
                return redirect('/civitas');
            }
        }

        return view('auth.register');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            Helper::logging($user->username, 'Auth', 'Login', 'User ' . $user->username . ' logged in');
            $cookie = cookie('jwtToken', $token, JWTAuth::factory()->getTTL() * 60);
            return redirect('/admin/dashboard')->withCookie($cookie);
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }
    }

    public function logout(Request $request)
    {
        $cookie = cookie('jwtToken', '', -1);
        Auth::logout();
        Helper::logging(Helper::getUsername($request), 'Auth', 'Logout', 'User ' . Helper::getUsername($request) . ' logged out');
        return redirect('/login')->withCookie($cookie);
    }
}
