<?php
namespace Modularlightspeed\Modularlightspeed\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'order.id' => 'required',
            'order.price_incl' => 'required',
            'webhook_url' => 'required|string',
            'redirect_url' => 'required|string',
        ];
    }
}
