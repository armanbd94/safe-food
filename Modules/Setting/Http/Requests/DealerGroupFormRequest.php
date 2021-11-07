<?php

namespace Modules\Setting\Http\Requests;

use App\Http\Requests\FormRequest;


class DealerGroupFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['group_name'] = ['required','string','unique:dealer_groups,group_name'];
        if(request()->update_id)
        {
            $rules['group_name'][2] = 'unique:dealer_groups,group_name,'.request()->update_id;
        }
        return $rules;
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
