<?php

namespace App\Http\Middleware;

use App\Models\Alert;
use Closure;
use Illuminate\Http\Request;

class headerCheck
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('manyPawKey') !== config('header.key')) {
            Alert::create([
                'msg' => 'İzinsiz giriş!',
                'line' => '0',
                'file' => '-',
                'user_id' => null,
                'ip_address' => $request->ip(),
                'code' => '0'
            ]);
            return response()->json([
                ':=)'
            ], 500);
        }
        return $next($request);
    }
}
