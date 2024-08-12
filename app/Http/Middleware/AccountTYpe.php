<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountTYpe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check())
        {
            return response()->json(['message'=> 'User is not aunthenticated'], 401);
        }
        if (Auth::user()->account_type !== 'creator')
        {
            return response()->json(['message'=> 'User cannot perform request'], 401);
        }
        return $next($request);
    }
}
