<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect based on role_id
            if ($user->role_id === 1) {
                return redirect('/admin/dashboard');
            } elseif ($user->role_id === 2) {
                return redirect('/manager/index');
            }
        }

        return $next($request);
    }
}
