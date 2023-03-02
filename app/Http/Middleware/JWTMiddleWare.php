<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class JWTMiddleWare
{
    public function handle(Request $request, Closure $next)
    {
        try {
			JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $status = 401;
            $error = 'Token authorization';
            $message = 'Authorization Token not found';
            return response()->json(array('status' => $status, 'error' => $error, 'message' => $message), 401);
        }
        return $next($request);
    }
}
