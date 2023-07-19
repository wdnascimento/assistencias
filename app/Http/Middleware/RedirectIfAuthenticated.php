<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;


        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'professor':
                        if (Auth::guard($guard)->check()) {
                            return redirect()->route('professor.home');
                        }
                    break;
                    case 'admin':
                      if (Auth::guard($guard)->check()) {
                        return redirect()->route('admin.dashboard');
                      }
                    break;

                    default:
                      if (Auth::guard()->check()) {
                          return redirect()->route('aluno.home');
                      }
                    break;
                  }
                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
