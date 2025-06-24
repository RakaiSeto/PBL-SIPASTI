<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check() && Auth::user()->role->role_nama == $role) {
            return $next($request);
        } else {
            if (!Auth::check()) {
                return redirect('/logout');
            } else {
            switch (Auth::user()->role->role_nama) {
                case 'Admin':
                    return redirect('/admin/dashboard');
                    break;
                case 'Teknisi':
                    return redirect('/teknisi/dashboard');
                    break;
                case 'Civitas':
                    return redirect('/civitas');
                    break;
                case 'Sarpras':
                    return redirect('/sarpras');
                    break;
                default:
                    return redirect('/logout');
                    break;
            }
            }
        }
    }
}
