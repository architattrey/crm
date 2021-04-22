<?php

namespace App\Http\Middleware;

use Closure;

class  IsSuper
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
        if (auth('admin')->user() &&  auth('admin')->user()->is_super == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
