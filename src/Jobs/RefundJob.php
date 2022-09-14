<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use ModularLightspeed\ModularLightspeed\API\Request\PutInvoiceData;
use ModularLightspeed\ModularLightspeed\Clients\lightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\lightspeed;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;
use ModularMultiSafepay\ModularMultiSafepay\Order\Item;
use ModularMultiSafepay\ModularMultiSafepay\Refund\CartRefund;
use ModularMultiSafepay\ModularMultiSafepay\Refund\Refund;

class RefundJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public lightspeed $lightspeed; // used in app service provider.
    protected $invoice;
    protected lightspeedClient $client;
    protected MultiSafepay $multiSafepay;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 360;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 390;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $invoice,
        lightspeed $lightspeed,
        lightspeedClient $client,
        MultiSafepay $multiSafepay
    )
    {
        $this->lightspeed = $lightspeed;
        $this->invoice = $invoice;
        $this->client = $client;
        $this->multiSafepay = $multiSafepay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if ($this->lightspeed->refunds()->find($this->invoice['id'])) {
            return;
        }

        $transaction = $this->multiSafepay->getTransaction($this->lightspeed->api_key, $this->invoice['order']['resource']['id']);

        if (!$transaction) {
            return;
        }

        $description = 'Refund: ' . $this->invoice['number'];
        $amount = abs(round($this->invoice['priceIncl'] * 100));
        $amount = ($transaction->amount - $transaction->amountRefunded >= $amount) ? $amount : $transaction->amount - $transaction->amountRefunded; // amount to refund can never exceed max amount refundable;

        if (!in_array($transaction->paymentDetails->type, CartRefund::REQUIRES_CART_REFUND)) {
            $refund = new Refund(
                $this->invoice['order']['resource']['id'],
                $this->invoice['id'],
                $amount,
                $transaction->currency,
                $description
            );
        } else {
            $shoppingCart = $transaction->shoppingCart;
            if ($shoppingCart === null) {
                return;
            }

            $shoppingCart->items[] = new Item(
                $this->invoice['id'],
                '(Refunded)' . $this->invoice['number'],
                $amount / 100.0,
                -1,
                0,
            );

            $refund = new CartRefund(
                $this->invoice['order']['resource']['id'],
                $this->invoice['id'],
                $shoppingCart,
                $description
            );
        }

        $refundStatus = $this->multiSafepay->createRefund($this->lightspeed->api_key, $refund);

        if ($refundStatus) {
            $this->lightspeed->refunds()->create([
                'invoice_id' => $this->invoice['id'],
                'order_id' => $this->invoice['order']['resource']['id'],
            ]);

            $this->client->makeRequest(new PutInvoiceData(
                $this->lightspeed->token,
                $this->invoice['id'],
            ));
        }
        sleep(300);
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(): array
    {
        return [
            new RateLimited('refunds'),
            (new WithoutOverlapping($this->lightspeed->token))->releaseAfter(330)
        ];
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return $this->invoice['id'];
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array
     */
    public function backoff()
    {
        return [300, 600, 900];
    }
}
