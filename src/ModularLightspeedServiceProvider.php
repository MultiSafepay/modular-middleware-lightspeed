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
            __DIR__ . '/../config/Lightspeed.php' => config_path('Lightspeed.php'),
            //Blades
            __DIR__.'/../resources/views/base.blade.php' => resource_path('views/Lightspeed/base.blade.php'),
            __DIR__.'/../resources/views/install.blade.php' => resource_path('views/Lightspeed/install.blade.php'),
            //JS
            __DIR__.'/../resources/js/checkoutv2/checkout.js' => public_path('js/Lightspeed/checkout.js'),
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
