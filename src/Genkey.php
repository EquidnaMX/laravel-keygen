<?php

namespace Ometra\Genkey;

use Ometra\Genkey\Models\KeyGenToken;

class Genkey
{
    public static function generateToken(string $appId): string
    {
        $token = bin2hex(random_bytes(20));
        $prepare = $token . ":" . $appId;
        $token = base64_encode($prepare);

        KeyGenToken::create([
            'token'  => $token,
            'app_id' => $appId,
        ]);

        return $token;
    }

    public static function validateToken(string $token): bool
    {
        $decoded = base64_decode($token);
        $parts = explode(":", $decoded);
        if (count($parts) !== 2) {
            return false;
        }
        $appId = $parts[1];
        $record = KeyGenToken::where('token', $token)
            ->where('app_id', $appId)
            ->first();

        return $record !== null;
    }
}
