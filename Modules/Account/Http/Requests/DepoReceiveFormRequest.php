<?php

namespace Modules\Account\Http\Requests;

use App\Http\Requests\FormRequest;


class DepoReceiveFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'voucher_no'   => 'required',
            'voucher_date' => 'required',
            'depo_id'  => 'required',
            'payment_type' => 'required',
            'account_id'   => 'required',
            'amount'       => 'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [

            'depo_id.required'  => 'The depo field is required',
            'account_id.required'   => 'The account field is required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
