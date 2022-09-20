<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ModularLightspeed\ModularLightspeed\API\Request\PutOrderData;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    protected $Lightspeed;
    protected $LightspeedClient;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = [30, 300, 1800, 3600, 10800];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $Lightspeed, $LightspeedClient)
    {
        $this->order = $order;
        $this->Lightspeed = $Lightspeed;
        $this->LightspeedClient = $LightspeedClient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : void
    {
        $financial = "not_paid";
        switch ($this->order['status']) {
            case 'completed':
                $status = 'paid';
                $financial = "paid";
                break;
            case 'initialized':
                is_array($this->order['payment_methods']) ? $status = 'pending' : $status = 'cancelled';
                break;
            case 'expired':
            case 'cancelled':
            case 'declined':
            case 'void':
                $status = 'cancelled';
                break;
            case 'uncleared':
            default:
                $status = 'pending';
                break;
        }

        $LightspeedOrder = new PutOrderData(
            $this->Lightspeed['token'],
            $this->order['order_id'],
            $status,
            $financial,
            $this->Lightspeed['language']
        );
        $this->LightspeedClient->makeRequest($LightspeedOrder);
    }
}
