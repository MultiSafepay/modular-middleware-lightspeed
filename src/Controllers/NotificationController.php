<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ModularLightspeed\ModularLightspeed\Clients\LightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\Lightspeed;
use ModularLightspeed\ModularLightspeed\Jobs\NotificationJob;

class NotificationController extends Controller
{
    public function __invoke(Request $request, Lightspeed $Lightspeed, LightspeedClient $LightspeedClient)
    {
        Log::info("Dispatching Ligthspeed Notification job",[
            'Request' => $request->all(),
            'Lightspeed' => $Lightspeed,
            'Order ID' => $request->order_id
        ]);
        NotificationJob::dispatch($request->all(),$Lightspeed, $LightspeedClient)->onQueue('LightspeedNotifications')->delay(now()->addSeconds(5));
        return response('OK');
    }
}
