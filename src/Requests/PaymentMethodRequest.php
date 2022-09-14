<?php
namespace Modularlightspeed\Modularlightspeed\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'billing_address.country' => 'required|string',
            'shop.currency' => 'required|string',
            'quote.price_incl' => 'required',
        ];
    }
}
