<?php

namespace Modules\Product\Http\Requests;

use App\Http\Requests\FormRequest;

class ProductFormRequest extends FormRequest
{
    protected $rules = [];
    protected $messages = [];
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['name']              = ['required','string','unique:products,name'];
        $this->rules['code']              = ['required','string','unique:products,code'];
        $this->rules['category_id']       = ['required'];
        $this->rules['barcode_symbology'] = ['required'];
        $this->rules['tax_id']            = ['nullable','numeric'];
        $this->rules['tax_method']        = ['required','numeric'];
        $this->rules['description']       = ['nullable','string'];
        $this->rules['image']             = ['nullable','image','mimes:png,jpg,jpeg,svg,webp'];
        
        if(request()->update_id){
            $this->rules['name'][2] = 'unique:products,name,'.request()->update_id;
            $this->rules['code'][2] = ['required','string','unique:products,code,'.request()->update_id];
            
        }
        $this->rules['base_unit_id']    = ['required'];
        $this->rules['unit_id']         = ['required'];
        $this->rules['alert_quantity']  = ['nullable','numeric','gte:0'];
        // $this->rules['base_unit_price'] = ['required','numeric','gt:0'];
        // $this->rules['unit_price']      = ['required','numeric','gt:0'];
        
        $this->messages['unit_id.required']      = 'The unit field is required';
        $this->messages['base_unit_id.required'] = 'The base unit field is required';

       
        $collection = collect(request());
        if($collection->has('prices')){
            foreach (request()->prices as $key => $value) {
                $this->rules ['prices.'.$key.'.dealer_group_id'] = ['required'];
                $this->rules ['prices.'.$key.'.base_unit_price'] = ['required','numeric','gt:0'];
                $this->rules ['prices.'.$key.'.unit_price']      = ['required','numeric','gt:0'];

                $this->messages['prices.'.$key.'.dealer_group_id.required']  = 'This field is required';

                $this->messages['prices.'.$key.'.base_unit_price.required'] = 'This filed value is required';
                $this->messages['prices.'.$key.'.base_unit_price.numeric']  = 'This filed value must be numeric';
                $this->messages['prices.'.$key.'.base_unit_price.gt']       = 'This filed value must be grater than 0';

                $this->messages['prices.'.$key.'.unit_price.required'] = 'This filed value is required';
                $this->messages['prices.'.$key.'.unit_price.numeric']  = 'This filed value must be numeric';
                $this->messages['prices.'.$key.'.unit_price.gt']       = 'This filed value must be grater than 0';
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
