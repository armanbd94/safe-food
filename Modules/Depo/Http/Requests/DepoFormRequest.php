<?php

namespace Modules\Depo\Http\Requests;

use App\Http\Requests\FormRequest;


class DepoFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['name']            = ['required','string','unique:depos,name'];
        $rules['mobile_no']       = ['nullable','string'];
        $rules['email']           = ['nullable','email','string'];
        $rules['address']         = ['nullable','string'];
        $rules['district_id']     = ['required'];
        $rules['commission_rate'] = ['nullable','numeric','gt:0'];

        if(request()->update_id)
        {
            $rules['name'] = 'unique:depos,name,'.request()->update_id;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'district_id.required' => 'The district name is required',
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
