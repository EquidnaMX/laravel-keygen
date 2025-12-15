<?php

namespace Equidna\KeyGen\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Equidna\KeyGen\Facades\KeyGen;

class ValidateToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token_str = $request->bearerToken();

        if (empty($token_str)) {
            return response()->json(['message' => 'Token not found'], 401);
        }

        if (!KeyGen::validateToken($token_str)) {
            return response()->json(['message' => 'Token not valid'], 401);
        }
        return $next($request);
    }
}
