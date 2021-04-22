<?php

namespace App\Http\Middleware;

use Closure;

class IsLg
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth('lg')->user() &&  auth('lg')->user()->is_lg == 3) {
            return $next($request);
        }
        return redirect('/');
    }
}
