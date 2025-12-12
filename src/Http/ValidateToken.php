<?php

namespace Ometra\Genkey\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Ometra\Genkey\Facades\GenKey;

class ValidateToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token_str = $request->bearerToken();

        if (empty($token_str)) {
            return response()->json(['message' => 'Token not found'], 401);
        }

        $isValid = GenKey::validateToken($token_str);

        if (!$isValid) {
            return response()->json(['message' => 'Token not valid'], 401);
        }
        return $next($request);
    }
}
