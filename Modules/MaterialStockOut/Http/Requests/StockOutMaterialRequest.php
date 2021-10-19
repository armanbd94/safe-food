<?php

namespace Modules\MaterialStockOut\Http\Requests;

use App\Http\Requests\FormRequest;

class StockOutMaterialRequest extends FormRequest
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
        $this->rules['stock_out_no'] = ['required','unique:stock_outs,stock_out_no'];
        $this->rules['date']  = ['required'];
        $this->rules['warehouse_id']  = ['required'];
        $this->rules['note']          = ['nullable'];
        if(request()->update_id)
        {
            $this->rules['stock_out_no'] = 'unique:stock_outs,stock_out_no,'.request()->update_id;
        }

        if(request()->has('materials'))
        {
            foreach (request()->materials as $key => $value) {
                $this->rules['materials.'.$key.'.id']       = ['required'];
                $this->rules['materials.'.$key.'.batch_no'] = ['required'];
                $this->rules['materials.'.$key.'.qty']      = ['required','numeric','gt:0'];
                
                $this->messages['materials.'.$key.'.id.required']       = 'The material field is required';
                $this->messages['materials.'.$key.'.batch_no.required'] = 'The batch no field is required';
                $this->messages['materials.'.$key.'.qty.required']      = 'The qty field is required';
                $this->messages['materials.'.$key.'.qty.numeric']       = 'The qty value must be numeric';
                $this->messages['materials.'.$key.'.qty.gt']            = 'The qty value must be greater than 0';
            }
        }
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages;
    }

    
    public function authorize()
    {
        return true;
    }
}
