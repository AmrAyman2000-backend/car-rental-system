<?php

namespace App\Http\Middleware;

use App\Http\Traits\apiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use apiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'admin') {
            return $this->apiResponse(403, 'Forbidden', 'You do not have permission to access this resource.', null);
        }

        return $next($request);
    }
}
