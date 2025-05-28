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
        $role = Auth::user()->role->role_nama;

        if ($role == 'Admin') {
            return redirect()->route('admin.dashboard');
        } else if ($role == 'Teknisi') {
            return redirect()->route('teknisi.dashboard');
        } else if ($role == 'Civitas') {
            return redirect()->route('civitas.dashboard');
        } else if ($role == 'Sarpras') {
            return redirect()->route('sarpras.dashboard');
        }
    }

    return view('auth.login');
}

public function register(Request $request)
{
    if (Auth::check()) {
        $role = Auth::user()->role->role_nama;

        if ($role == 'Admin') {
            return redirect()->route('admin.dashboard');
        } else if ($role == 'Teknisi') {
            return redirect()->route('teknisi.dashboard');
        } else if ($role == 'Civitas') {
            return redirect()->route('civitas.dashboard');
        } else if ($role == 'Sarpras') {
            return redirect()->route('sarpras.dashboard');
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

        $role = $user->role->role_nama;

        if ($role == 'Admin') {
            return redirect()->route('admin.dashboard')->withCookie($cookie);
        } else if ($role == 'Teknisi') {
            return redirect()->route('teknisi.dashboard')->withCookie($cookie);
        } else if ($role == 'Civitas') {
            return redirect()->route('civitas.dashboard')->withCookie($cookie);
        } else if ($role == 'Sarpras') {
            return redirect()->route('sarpras.dashboard')->withCookie($cookie);
        }
    } else {
        return redirect()->back()->withErrors(['error' => 'Username atau password salah']);
    }
}

public function logout(Request $request)
{
    $cookie = cookie('jwtToken', '', -1);
    Helper::logging(Helper::getUsername($request), 'Auth', 'Logout', 'User ' . Helper::getUsername($request) . ' logged out');
    Auth::logout();
    return redirect()->route('home')->withCookie($cookie);
}

}
