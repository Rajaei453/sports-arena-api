<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'owner') {
            return response()->json(['error' => 'Access denied. Only owners can perform this action.'], 403);
        }

        return $next($request);
    }
}
