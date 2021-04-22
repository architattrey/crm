<?php

namespace App\Http\Middleware;

use Closure;

class IsBdm
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
       
        if (auth('bdm')->user() &&  auth('bdm')->user()->is_bdm == 2) {
            return $next($request);
        }
        return redirect('/');
    }
}
