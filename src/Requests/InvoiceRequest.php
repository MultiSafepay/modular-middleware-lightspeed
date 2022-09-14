<?php
namespace ModularLightspeed\ModularLightspeed\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class InvoiceRequest extends FormRequest
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
            'invoice.id' => 'required|unique:lightspeed_refunds,invoice_id',
            'invoice.order.resource.id' => 'required',
            'invoice.priceIncl' => 'required|lt:0',
            'invoice.isCreditNote' => 'required|boolean|accepted',
            'invoice.status' => 'required|not_in:paid',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //Required
            'invoice.order.resource.id.required' => 'An order ID is required',
            'invoice.id.required' => 'An invoice ID is Required',
            'invoice.priceIncl.required' => 'Price inclusive is Required',
            'invoice.isCreditNote.required' => 'isCreditNote is Required',
            'invoice.status.required' => 'Status is Required',

            //Other
            'invoice.id.not_in' => 'Invoice with :id already exist',
            'invoice.priceIncl.lt' => 'Price must be lower than 0',
            'invoice.isCreditNote.boolean' => 'isCreditNote must be a Boolean',
            'invoice.isCreditNote.accepted' => 'isCreditNote must be true',
            'invoice.status.not_in' => 'Invoice status must not be paid',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, $validator->errors()));
    }
}
