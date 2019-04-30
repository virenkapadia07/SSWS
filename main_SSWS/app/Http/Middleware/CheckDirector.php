<?php

namespace App\Http\Middleware;

use Closure;

class CheckDirector
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
        if($request->session()->get('director') ===null)
        {
            return redirect('/');
        }
        return $next($request);
    }
}
