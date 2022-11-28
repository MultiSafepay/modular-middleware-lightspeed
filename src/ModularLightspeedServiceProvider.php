<?php

namespace ModularLightspeed\ModularLightspeed;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use ModularLightspeed\ModularLightspeed\Clients\LightspeedClient;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModularLightspeedServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        //Load Custom routes into laravel
        $this->loadRoutesFrom(__DIR__ . '/routes/Lightspeed.php');

        //Enable custom Horizon supervisor
        Config::set(
            'horizon.defaults.supervisor-Lightspeed',
            [
                'connection' => 'redis',
                'queue' => ['LightspeedNotifications','LightspeedRefunds'],
                'balance' => 'auto',
                'maxProcesses' => 2,
                'maxTime' => 0,
                'maxJobs' => 0,
                'memory' => 128,
                'tries' => 0,
                'timeout' => 60,
                'nice' => 0,
            ]
        );

        //Publish the required files
        $this->publishes([

            //Config
            __DIR__ . '/../config/Lightspeed.php' => config_path('lightspeed.php'),
            //favicon
            __DIR__.'/../resources/favicon.ico' => public_path('lightspeed/favicon.ico'),
            __DIR__.'/../resources/favicon.svg' => public_path('lightspeed/favicon.svg'),
            __DIR__.'/../resources/favicon-mask.svg' => public_path('lightspeed/favicon-mask.svg'),
            //Images
            __DIR__.'/../resources/images/msp-logo-white.svg' => public_path('images/lightspeed/msp-logo-white.svg'),
            //Blades
            __DIR__.'/../resources/views/base.blade.php' => resource_path('views/lightspeed/base.blade.php'),
            __DIR__.'/../resources/views/install.blade.php' => resource_path('views/lightspeed/install.blade.php'),
            //JS
            __DIR__.'/../resources/js/checkoutv2/checkout.js' => public_path('js/lightspeed/checkout.js'),
            //Migrations
            __DIR__.'/../database/migrations/create_lightspeed_table.php.stub' => database_path('migrations/create_lightspeed_table.php'),
            __DIR__.'/../database/migrations/create_lightspeed_refund_table.php.stub' => database_path('migrations/create_lightspeed_refund_table.php'),
        ], 'modular-middleware');
    }

    public function configurePackage(Package $package): void
    {

        $package->name('modular-middleware-Lightspeed');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LightspeedClient::class, function ($app) {
            return new LightspeedClient(config('Lightspeed.apiUrl'));
        });
    }

}
