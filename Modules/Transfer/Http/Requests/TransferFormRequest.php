<?php

namespace Modules\Transfer\Http\Requests;

use App\Http\Requests\FormRequest;

class TransferFormRequest extends FormRequest
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
        $this->rules['chalan_no']         = ['required','unique:transfers,chalan_no'];
        $this->rules['transfer_date']     = ['required','date','date_format:Y-m-d'];
        $this->rules['from_warehouse_id'] = ['required'];
        $this->rules['to_warehouse_id']   = ['required','different:from_warehouse_id'];
        $this->rules['carried_by']        = ['required'];
        $this->rules['received_by']       = ['required'];
        $this->rules['shipping_cost']     = ['nullable','numeric', 'gte:0'];
        $this->rules['labor_cost']        = ['nullable','numeric', 'gte:0'];
        if(request()->update_id)
        {
            $this->rules['chalan_no'][1] = 'unique:transfers,chalan_no,'.request()->update_id;
        }
        if(request()->has('products'))
        {
            foreach (request()->products as $key => $value) {
                $this->rules['products.'.$key.'.qty']             = ['required','numeric','gt:0','lte:'.$value['stock_qty']];
                $this->messages['products.'.$key.'.qty.required'] = 'This field is required';
                $this->messages['products.'.$key.'.qty.numeric']  = 'The value must be numeric';
                $this->messages['products.'.$key.'.qty.gt']       = 'The value must be greater than 0';
                $this->messages['products.'.$key.'.qty.lte']       = 'The value must be less than stock available quantity';
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
