<?php

namespace Ometra\Genkey\console\commands;

use Illuminate\Console\Command;
use Ometra\Genkey\Genkey;

use function Laravel\Prompts\note;
use function Laravel\Prompts\text;

class CreateToken extends Command
{
    protected $signature = 'generate-token';
    protected $description = 'generate token';

    public function handle()
    {
        note('Generacion de un token:');
        $id = text('Escribe el id de la app:');
        $token = GenKey::generateToken($id);
        $this->info("¡Listo! El token se genero correctamente {$token}");
        return 0;
    }
}
