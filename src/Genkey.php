<?php

namespace Ometra\Genkey;

use Ometra\Genkey\Models\KeyGenToken;
use Illuminate\Support\Str;

class Genkey
{
    public static function generateToken(string $nombre): string
    {
        $token = Str::random(40);
        $hashedToken = hash('sha256', $token);

        KeyGenToken::create([
            'token'  => $hashedToken,
            'nombre' => $nombre,
        ]);

        return $token;
    }

    public static function validateToken(string $token): bool
    {
        $hashedToken = hash('sha256', $token);
        if (KeyGenToken::findOrFail($hashedToken)) {
            return true;
        }
        return false;
    }
}
