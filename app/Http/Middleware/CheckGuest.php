<?php

namespace App\Http\Middleware;

use Closure;

class CheckGuest
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
        return (session('logged')) ? redirect('dashboard') : $next($request);
    }
}
