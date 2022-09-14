<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ModularLightspeed\ModularLightspeed\Clients\lightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\lightspeed;
use ModularLightspeed\ModularLightspeed\Jobs\NotificationJob;

class NotificationController extends Controller
{
    public function __invoke(Request $request, lightspeed $lightspeed, lightspeedClient $lightspeedClient)
    {
        Log::info("Dispatching Ligthspeed Notification job",[
            'Request' => $request->all(),
            'lightspeed' => $lightspeed,
            'Order ID' => $request->order_id
        ]);
        NotificationJob::dispatch($request->all(),$lightspeed, $lightspeedClient)->onQueue('lightspeedNotifications')->delay(now()->addSeconds(5));
        return response('OK');
    }
}
