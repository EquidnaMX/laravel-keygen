<?php

namespace Ometra\Genkey\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Ometra\Genkey\console\commands\CreateToken;
use Ometra\Genkey\Genkey;

class GenKeyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrar cosas en el contenedor de servicios
        $this->app->singleton(
            Genkey::class,
            fn() => new Genkey()
        );
    }

    public function boot(Router $router)
    {
        $router->aliasMiddleware('GenKey.ValidateToken', \Ometra\Genkey\Http\Middleware\ValidateToken::class);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        //Migrations
        $this->publishes(
            [
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ],
            [
                'token:migrations',
                'tokens'
            ]
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateToken::class,
            ]);
        }
    }
}
