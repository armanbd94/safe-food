<?php

namespace Modules\GuestGift\Http\Requests;

use App\Http\Requests\FormRequest;

class GuestGiftFormRequest extends FormRequest
{
    protected $rules;
    protected $messages;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['voucher_no']         = ['required','unique:guest_gifts,voucher_no'];
        $this->rules['guest_name']         = ['required'];
        $this->rules['gift_from']         = ['required'];
        $this->rules['date']       = ['required','date','date_format:Y-m-d'];
        if(request()->gift_id)
        {
            $this->rules['voucher_no'][1]  = 'unique:guest_gifts,voucher_no,'.request()->gift_id;
        }

        if(request()->has('products'))
        {
            foreach (request()->products as $key => $value) {

                $this->rules['products.'.$key.'.qty']             = ['required','numeric','gt:0'];
                $this->messages['products.'.$key.'.qty.required'] = 'This field is required';
                $this->messages['products.'.$key.'.qty.numeric']  = 'The value must be numeric';
                $this->messages['products.'.$key.'.qty.gt']       = 'The value must be greater than 0';
                
            }
        }
        
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages;
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
