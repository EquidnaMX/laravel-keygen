<?php

namespace Equidna\KeyGen\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Equidna\KeyGen\console\commands\CreateToken;
use Equidna\KeyGen\KeyGen;

class KeyGenServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrar cosas en el contenedor de servicios
        $this->app->singleton(
            KeyGen::class,
            fn() => new KeyGen()
        );
    }

    public function boot(Router $router)
    {
        $router->aliasMiddleware('KeyGen.ValidateToken', \Equidna\KeyGen\Http\Middleware\ValidateToken::class);
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
