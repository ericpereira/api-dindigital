<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

use Flugg\Responder\Responder;

class ApiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return responder()->error(400, 'Token inválido')->respond();
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return responder()->error(400, 'Token expirado')->respond();
            }else{
                return responder()->error(400, 'Token de autorização não encontrado')->respond();
            }
        }
        return $next($request);
    }
}
