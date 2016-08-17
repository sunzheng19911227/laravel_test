<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AttrRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:255',
            'input_name'=>'required|max:255',
            'input_box_type'=>'required|numeric',
            'input_value_type'=>'required|numeric',
            'status'=>'required|numeric',
            'sort_order'=>'numeric',
        ];
    }
}
