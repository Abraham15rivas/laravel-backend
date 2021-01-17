<?php

namespace App\Http\Middleware;

use Closure;

class Guest
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
        $user = \Auth::user();
        if ($user->role_id == 2) {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
