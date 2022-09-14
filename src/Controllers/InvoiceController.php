<?php
namespace ModularLightspeed\ModularLightspeed\Controllers;

use App\Http\Controllers\Controller;
use ModularLightspeed\ModularLightspeed\Clients\lightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\lightspeed;
use ModularLightspeed\ModularLightspeed\Requests\InvoiceRequest;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;
use ModularLightspeed\ModularLightspeed\Jobs\RefundJob;

class InvoiceController extends Controller
{
    public function store(
        InvoiceRequest   $request,
        lightspeed       $lightspeed,
        lightspeedClient $client,
        MultiSafepay     $multiSafepay
    )
    {
        RefundJob::dispatch(
            $request->invoice,
            $lightspeed,
            $client,
            $multiSafepay
        )->onQueue('refunds');
    }
}
