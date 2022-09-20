<?php
namespace ModularLightspeed\ModularLightspeed\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use ModularLightspeed\ModularLightspeed\API\Request\GetOrderData;
use ModularLightspeed\ModularLightspeed\Clients\LightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\Lightspeed;
use ModularLightspeed\ModularLightspeed\Requests\PaymentRequest;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;
use ModularMultiSafepay\ModularMultiSafepay\Order\CustomerInfo;
use ModularMultiSafepay\ModularMultiSafepay\Order\DeliveryInfo;
use ModularMultiSafepay\ModularMultiSafepay\Order\Item;
use ModularMultiSafepay\ModularMultiSafepay\Order\Order;
use ModularMultiSafepay\ModularMultiSafepay\Order\PaymentOptions;
use ModularMultiSafepay\ModularMultiSafepay\Order\ShoppingCart;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request, MultiSafepay $multiSafepay, LightspeedClient $LightspeedClient, Lightspeed $Lightspeed): JsonResponse
    {
        $orderData = new GetOrderData(
            $request->order['id'],
            $Lightspeed->token,
            $Lightspeed->language
        );

        $orderRequest = $LightspeedClient->makeRequest($orderData);

        Log::info('PAYMENT INFO',[$orderRequest]);

        $customerFullName = explode(' ', $orderRequest['addressShippingName']);
        $customerFirstname = array_shift($customerFullName);
        $customerLastname = implode(' ', $customerFullName);

        $delivery = new DeliveryInfo(
            $customerFirstname,
            $customerLastname,
            $orderRequest['addressShippingStreet'],
            $orderRequest['addressShippingNumber'],
            $orderRequest['addressShippingZipcode'],
            $orderRequest['addressShippingCity'],
            $orderRequest['addressShippingCountry'],
        );

        $customerFullName = explode(' ', $orderRequest['addressBillingName']);
        $customerFirstname = array_shift($customerFullName);
        $customerLastname = implode(' ', $customerFullName);

        $customer = new CustomerInfo(
            $customerFirstname,
            $customerLastname,
            $orderRequest['birthDate'],
            $orderRequest['phone'],
            $orderRequest['email'],
            $orderRequest['gender'],
            $orderRequest['addressBillingStreet'],
            $orderRequest['addressBillingNumber'],
            $orderRequest['addressBillingZipcode'],
            $orderRequest['addressBillingCity'],
            $orderRequest['addressBillingCountry'],
        );

        $items = array_map(static function ($product) {
            return new Item(
                $product['id'],
                $product['productTitle'],
                (float)$product['basePriceExcl'],
                $product['quantityOrdered'],
                (float)$product['taxRates'][0]['rate']
            );
        }, $orderRequest['products']);

        $items[] = new Item(
            $orderRequest['shipmentId'],
            $orderRequest['shipmentTitle'],
            (float)$orderRequest['shipmentPriceExcl'],
            1,
            (float)$orderRequest['shipmentTaxRate'],
        );

        if ($orderRequest['paymentPriceExcl'] > 0) {
            $items[] = new Item(
                'payment_fee',
                $orderRequest['paymentTitle'],
                (float)$orderRequest['paymentPriceExcl'],
                1,
                (float)$orderRequest['paymentTaxRate'],
            );
        }

        $shoppingCart = new ShoppingCart($items);

        $payload = $request['payment_method']['data']['payload'] ?? null;

        $order = new Order(
            $orderRequest['id'],
            ($request->order['price_incl'] * 100),
            strtoupper($request->order['currency']),
            $orderRequest['paymentMethod'],
            ($payload ?? null) === null ? 'redirect' : 'direct',
            'MW' . $orderRequest['id'],
            new PaymentOptions($request->redirect_url, $request->redirect_url, route('Lightspeed.notification', $Lightspeed->uuid), true, true),
            $customer,
            $delivery,
            $payload,
            $shoppingCart
        );

        $url = $multiSafepay->createTransaction($Lightspeed->api_key, $order);

        return response()->json(['payment_url' => $url], 201);
    }
}
