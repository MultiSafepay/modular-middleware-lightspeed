<?php

namespace ModularLightspeed\ModularLightspeed;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModularLightspeedServiceProvider extends PackageServiceProvider
{

    public function boot(): void
    {
        //Load Custom routes into laravel
        $this->loadRoutesFrom(__DIR__ . '/routes/lightspeed.php');

        //Enable custom Horizon supervisor
        Config::set(
            'horizon.defaults.supervisor-lightspeed',
            [
                'connection' => 'redis',
                'queue' => ['default','template-high','template-low'],
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

    }

    public function configurePackage(Package $package): void
    {
        //Publish the required files
        $this->publishes([
            //Config
            __DIR__.'/../config/lightspeed.php' => config_path('lightspeed.php'),
            //Migrations
            __DIR__.'/../database/migrations/create_lightspeed_table.php.stub' => database_path('migrations/2021_10_15_105837_create_lightspeed_table.php'),
            __DIR__.'/../database/migrations/create_lightspeed_refund_table.php.stub' => database_path('migrations/2021_12_06_120237_create_lightspeed_refund_table.php'),
        ], 'modular-middleware');

        $package->name('modular-middleware-lightspeed');
    }
}
