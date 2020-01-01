<?php

namespace Shetabit\Crypto\Provider;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Shetabit\Crypto\Crypto;

class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Migrations that needs to be done by user.
         */
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/' => database_path('migrations')
            ],
            'migrations'
        );

        $this->registerMacroHelpers();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Load default configurations.
         */
        $this->mergeConfigFrom(
            __DIR__.'/../../config/crypto.php', 'crypto'
        );

        /**
         * Bind to service container.
         */
        $this->app->singleton('shetabit-crypto', function () {
            $request = app(Request::class);

            return new Crypto($request, config('crypto'));
        });
    }

    /**
     * Register micros
     */
    protected function registerMacroHelpers()
    {

    }
}
