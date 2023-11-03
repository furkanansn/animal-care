<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class setLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user('api') || $request->user('web')) {

            $user = $request->user('api') ?? $request->user('web');
            $user->update([
                'last_activity' => (string) time(),
            ]);

        }
        return $next($request);
    }
}
