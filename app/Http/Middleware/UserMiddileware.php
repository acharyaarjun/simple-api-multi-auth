<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddileware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->is_doctor == 'N' && $user->is_admin == 'N') {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Unauthenticated",
                'date' => Carbon::now()->toJSON(),
                'data' => null
            ], 401);
        }
    }
}
