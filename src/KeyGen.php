<?php

namespace Equidna\KeyGen;

use Equidna\KeyGen\Models\KeyGenToken;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KeyGen
{
    public $plainToken = null;
    private KeyGenToken $keyGen_model;
    public function __construct()
    {
        //
    }

    public static function generateToken(string $nombre): static
    {
        $token = Str::random(40);
        $hashedToken = hash('sha256', $token);

        $tokenModel = KeyGenToken::create([
            'token'  => $hashedToken,
            'nombre' => $nombre,
        ]);
        $tokenClass = new static();
        $tokenClass->keyGen_model = $tokenModel;
        $tokenClass->plainToken = $token;
        return $tokenClass;
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

    public function attachToken(Model $entitiy)
    {
        $this->keyGen_model->tokeneable()->associate($entitiy);
        $this->keyGen_model->save();
        return $this;
    }
}
