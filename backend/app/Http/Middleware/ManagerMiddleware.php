<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id === 2) {
            return $next($request); 
        }

        return response(
            "<script>
                alert('You have no right to access this page or you need to login again with admin account'); 
            </script>"
        );
    }
}

