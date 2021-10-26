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
        $this->rules['avatar']           = ['nullable','image', 'mimes:png,jpg,jpeg,svg'];
        $this->rules['address']          = ['nullable', 'string'];
        $this->rules['type']             = ['required'];
        $this->rules['district_id']      = ['required'];
        $this->rules['upazila_id']       = ['required'];
        $this->rules['areas']            = ['required','array'];
        $this->rules['commission_rate']  = ['nullable','gte:0'];
        $this->rules['previous_balance'] = ['nullable','gte:0'];
        if(request()->type == 1){
            $this->rules['depo_id']          = ['required'];
        }
        
        if(request()->update_id){
            $this->rules['mobile_no'][3]      = 'unique:dealers,mobile_no,'.request()->update_id;
            $this->rules['email'][3]                 = 'unique:dealers,email,'.request()->update_id;
        }

        return $this->rules;
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
