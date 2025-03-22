<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'customer') {
            return response()->json(['error' => 'Access denied. Only customers can perform this action.'], 403);
        }

        return $next($request);
    }
}
