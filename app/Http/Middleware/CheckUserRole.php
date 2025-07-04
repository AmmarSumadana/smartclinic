<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response; // Pastikan ini di-import

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if not authenticated
        }

        $user = Auth::user();

        // Check if the user's role is in the allowed roles list
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request); // User has the required role, proceed
            }
        }

        // If user does not have any of the allowed roles
        abort(403, 'Unauthorized. Anda tidak memiliki peran yang diperlukan untuk mengakses halaman ini.');
    }
}
