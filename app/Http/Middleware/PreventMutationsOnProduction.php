<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventMutationsOnProduction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production')) {
            if (
                $request->isMethod('post') ||
                $request->isMethod('put') ||
                $request->isMethod('delete')
            ) {
                return response()->json(['message' => 'Unauthorized action.'], 500);
            }
        }

        return $next($request);
    }
}
