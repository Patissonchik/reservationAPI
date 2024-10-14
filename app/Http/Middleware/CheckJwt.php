<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CheckJwt
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
            if (JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'Доступ запрещен. Пользователь не найден.'], 403);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Токен истек. Пожалуйста, авторизуйтесь снова.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Недействительный токен.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ошибка авторизации.'], 403);
        }

        return $next($request);
    }
}
