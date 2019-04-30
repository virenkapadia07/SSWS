<?php

namespace App\Http\Middleware;

use Closure;

class GateKeeperMiddleware
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
        if($request->session()->get('gatekeeper') ===null)
        {
            return redirect('gatekeeper');
        }
        return $next($request);
    }
}
