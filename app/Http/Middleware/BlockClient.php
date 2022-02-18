<?php

namespace LaraBooking\Http\Middleware;

use Closure;

class BlockClient
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
        if($request->user()->isClient()) {
            return redirect('/');
        }

        return $next($request);
    }
}
