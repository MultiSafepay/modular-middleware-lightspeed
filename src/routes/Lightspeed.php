<?php

use Illuminate\Routing\Middleware\SubstituteBindings;
use ModularLightspeed\ModularLightspeed\Controllers\InvoiceController;
use ModularLightspeed\ModularLightspeed\Controllers\NotificationController;
use ModularLightspeed\ModularLightspeed\Controllers\PaymentMethodController;
use ModularLightspeed\ModularLightspeed\Middleware\LightspeedMiddleware;
use ModularLightspeed\ModularLightspeed\Controllers\PaymentController;
use ModularLightspeed\ModularLightspeed\Controllers\InstallController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'Lightspeed',
    'as' => 'Lightspeed.',
    'middleware' => SubstituteBindings::class
], function () {
    /**
     * Onboard Routes
     */
    Route::get('success', [InstallController::class, 'store'])->name('install.success');

    Route::resource('install', InstallController::class)
        ->parameter('install', 'Lightspeed')
        ->middleware('web')
        ->only(['show', 'update']);

    Route::post('{Lightspeed}/notification', NotificationController::class)->name('notification');

    /**
     * Payment, Webhook routes
     */
    Route::group([
        'prefix' => '{Lightspeed}',
        'middleware' => LightspeedMiddleware::class
    ], function () {
        Route::get('alive', function() {
            return response()->json(["success" => true]);
        })->name('alive');

        Route::post('payment', [PaymentController::class, 'store'])->name('payment.store');
        Route::post('payment_methods', [PaymentMethodController::class, 'all'])->name('paymentMethods.post');

        Route::group([
            'prefix' => 'webhook',
            'as' => 'webhook.'
        ], function () {
            Route::post('shipments/created', function (){ return []; })->name('shipments.created');
            Route::post('shipments/updated', function (){ return []; })->name('shipments.updated');
            Route::post('shipments/deleted', function (){ return []; })->name('shipments.deleted');

            Route::post('invoice/created', [InvoiceController::class, 'store'])->name('invoice.created');
            Route::post('invoice/updated', function (){ return []; })->name('invoice.updated');
        });
    });
});
