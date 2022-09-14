<?php
namespace Modularlightspeed\Modularlightspeed\Controllers;

use App\Http\Controllers\Controller;
use Modularlightspeed\Modularlightspeed\Clients\lightspeedClient;
use Modularlightspeed\Modularlightspeed\Models\lightspeed;
use Modularlightspeed\Modularlightspeed\Requests\InvoiceRequest;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;
use ModularTemplate\ModularTemplate\Jobs\RefundJob;

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
