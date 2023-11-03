<?php

namespace App\Http\Middleware;

use App\Http\Traits\ReturnResponse;
use Closure;
use Illuminate\Http\Request;

class isLogged
{
    use ReturnResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user('api')) {
            return $this->sendError('Lütfen çıkış yapınız!', 403);
        }
        return $next($request);
    }
}
