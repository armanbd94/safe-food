<?php

namespace Modules\Sale\Http\Requests;

use App\Http\Requests\FormRequest;

class SaleFormRequest extends FormRequest
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
        $this->rules['memo_no']         = ['required','unique:sales,memo_no'];
        if(request()->sale_id)
        {
            $this->rules['memo_no'][1]  = 'unique:sales,memo_no,'.request()->sale_id;
        }
        $this->rules['sale_date']       = ['required','date','date_format:Y-m-d'];
        $this->rules['delivery_date']   = ['required','date','date_format:Y-m-d','after_or_equal:sale_date'];
        if(request()->order_from == 1){
            $this->rules['depo_dealer_id']     = ['required'];
        }elseif (request()->order_from == 2) {
            $this->rules['direct_dealer_id']   = ['required'];
        }

        if(request()->has('products'))
        {
            foreach (request()->products as $key => $value) {
                $this->rules['products.'.$key.'.unit_qty']             = ['required','numeric','gt:0'];
                $this->messages['products.'.$key.'.unit_qty.required'] = 'This field is required';
                $this->messages['products.'.$key.'.unit_qty.numeric']  = 'The value must be numeric';
                $this->messages['products.'.$key.'.unit_qty.gt']       = 'The value must be greater than 0';

                $this->rules['products.'.$key.'.qty']             = ['required','numeric','gt:0'];
                $this->messages['products.'.$key.'.qty.required'] = 'This field is required';
                $this->messages['products.'.$key.'.qty.numeric']  = 'The value must be numeric';
                $this->messages['products.'.$key.'.qty.gt']       = 'The value must be greater than 0';
                
                $this->rules['products.'.$key.'.free_qty']             = ['nullable','numeric','gte:0'];
                $this->messages['products.'.$key.'.free_qty.numeric']  = 'The value must be numeric';
                $this->messages['products.'.$key.'.free_qty.gte']       = 'The value could be greater than or equal 0';
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
