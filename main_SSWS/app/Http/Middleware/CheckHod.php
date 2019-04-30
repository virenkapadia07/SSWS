<?php

namespace App\Http\Middleware;

use Closure;

class CheckHod
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
        if($request->session()->get('hod') ===null)
        {
            return redirect('/');
        }
        return $next($request);
    }
}
