<?php

namespace Modules\Dealer\Http\Requests;

use App\Http\Requests\FormRequest;

class DealerFormRequest extends FormRequest
{
    protected $rules = [];
    protected $messages = [];

    public function rules()
    {
        $this->rules['name']             = ['required', 'string'];
        $this->rules['mobile_no']        = ['required', 'string', 'max:15', 'unique:dealers,mobile_no'];
        $this->rules['email']            = ['nullable', 'string', 'email', 'unique:dealers,email'];
        $this->rules['address']          = ['nullable', 'string'];
        $this->rules['district_id']      = ['required'];
        $this->rules['upazila_id']       = ['required'];
        $this->rules['area_id']          = ['required'];
        $this->rules['type']             = ['required'];
        if(request()->type == 1){
            $this->rules['depo_id']          = ['required'];
        }
        
        $this->rules['dealer_group_id']  = ['required'];
        $this->rules['commission_rate']  = ['nullable','gte:0'];
        $this->rules['previous_balance'] = ['nullable','gte:0'];

        if(request()->update_id){
            $this->rules['mobile_no'][3]      = 'unique:dealers,mobile_no,'.request()->update_id;
            $this->rules['email'][3]          = 'unique:dealers,email,'.request()->update_id;
        }

        return $this->rules;
    }

    public function messages()
    {
        return [
            'district_id.required'     => 'The district name is required',
            'upazila_id.required'      => 'The upazila name is required',
            'area_id.required'         => 'The area name is required',
            'dealer_group_id.required' => 'The dealer group is required',
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
