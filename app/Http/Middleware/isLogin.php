<?php

namespace App\Http\Middleware;

use App\Http\Traits\ReturnResponse;
use Closure;
use Illuminate\Http\Request;

class isLogin
{
    use ReturnResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user('api')) {
            return $this->sendError('Yetkisiz giriş!', 401);
        }

        $user = $request->user('api');
        $user->update([
            'last_activity' => time(),
            'user_agent' => $request->userAgent()
        ]);

        return $next($request);
    }
}
