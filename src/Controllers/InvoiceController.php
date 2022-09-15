<?php
namespace ModularLightspeed\ModularLightspeed\Controllers;

use App\Http\Controllers\Controller;
use ModularLightspeed\ModularLightspeed\Clients\LightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\Lightspeed;
use ModularLightspeed\ModularLightspeed\Requests\InvoiceRequest;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;
use ModularLightspeed\ModularLightspeed\Jobs\RefundJob;

class InvoiceController extends Controller
{
    public function store(
        InvoiceRequest   $request,
        Lightspeed       $Lightspeed,
        LightspeedClient $client,
        MultiSafepay     $multiSafepay
    )
    {
        RefundJob::dispatch(
            $request->invoice,
            $Lightspeed,
            $client,
            $multiSafepay
        )->onQueue('refunds');
    }
}
