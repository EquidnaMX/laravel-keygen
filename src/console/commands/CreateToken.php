<?php

namespace Equidna\KeyGen\console\commands;

use Illuminate\Console\Command;
use Equidna\KeyGen\KeyGen;

use function Laravel\Prompts\note;
use function Laravel\Prompts\text;

class CreateToken extends Command
{
    protected $signature = 'generate-token';
    protected $description = 'generate token';

    public function handle()
    {
        note('Generacion de un token:');
        $nombre = text('Escribe el nombre del token:');
        $token = KeyGen::generateToken($nombre);
        $this->info("¡Listo! El token se genero correctamente << {$token->plainToken} >>");
        return 0;
    }
}
