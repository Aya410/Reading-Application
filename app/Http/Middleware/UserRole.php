<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$roles): Response
    {
        $user = auth()->user();
         if (!$user || $user->role != $roles)
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
               return $next($request);
      
    }
}
