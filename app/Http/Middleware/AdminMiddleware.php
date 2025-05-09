<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Gate::allows('isAdmin')) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}