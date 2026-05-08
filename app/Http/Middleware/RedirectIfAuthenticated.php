<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::check() && (Auth::user()->getRoleNames()[0] == 'admin')) {
                return redirect('admin/dashboard');
            } elseif (Auth::check() &&  (Auth::user()->getRoleNames()[0] == 'teacher')) {
                return redirect('teacher/dashboard');
            } elseif (Auth::check() &&  (Auth::user()->getRoleNames()[0] == 'student')) {
                return redirect('student/dashboard');
            } else {
                return $next($request);
            }
        }

        return $next($request);
    }
}
