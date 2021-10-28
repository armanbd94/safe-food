<?php

namespace Modules\Depo\Http\Requests;

use App\Http\Requests\FormRequest;


class DepoFormRequest extends FormRequest
{
    protected $rules = [];
    protected $messages = [];
    
    public function rules()
    {
        $this->rules['name']             = ['required', 'string'];
        $this->rules['mobile_no']        = ['required', 'string', 'max:15', 'unique:depos,mobile_no'];
        $this->rules['email']            = ['nullable', 'string', 'email', 'unique:depos,email'];
        $this->rules['address']          = ['nullable', 'string'];
        $this->rules['district_id']      = ['required'];
        $this->rules['upazila_id']       = ['required'];
        $this->rules['area_id']          = ['required'];
        $this->rules['commission_rate']  = ['nullable','gte:0'];
        $this->rules['previous_balance'] = ['nullable','gte:0'];

        if(request()->update_id){
            $this->rules['mobile_no'][3]      = 'unique:depos,mobile_no,'.request()->update_id;
            $this->rules['email'][3]          = 'unique:depos,email,'.request()->update_id;
        }
        return $this->rules;
    }

    public function messages()
    {
        return [
            'district_id.required' => 'The district name is required',
            'upazila_id.required' => 'The upazila name is required',
            'area_id.required' => 'The area name is required',
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
