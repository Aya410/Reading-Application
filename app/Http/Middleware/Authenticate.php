<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
  //  public  function handle($request, Closure $next, ...$guards)
   // {
        //$token = JWTAuth::parseToken()->authenticate();
       // $user = $token->user;
      //  if ($user && $user->last_password_updated && $token->hasClaim('iat') && $token->getClaim('iat') < $user->last_password_updated) {
        //    throw new TokenInvalidException('Token is invalid because the user password was changed.');
      //  }
        //if ($user->last_password_updated && $token->getClaim('iat') < $user->last_password_updated) {
         //   throw new TokenInvalidException('Token is invalid because the user password was changed.');
        
        //}
      //  return $next($request);
   // }
}
