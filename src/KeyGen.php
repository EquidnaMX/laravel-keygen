<?php

namespace Equidna\KeyGen;

use Equidna\KeyGen\Models\KeyGenToken;
use Exception;
use Illuminate\Support\Str;

class KeyGen
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
        try {
            if (KeyGenToken::findOrFail($hashedToken)) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }
}
