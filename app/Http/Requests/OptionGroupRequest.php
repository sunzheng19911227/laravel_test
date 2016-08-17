<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OptionGroupRequest extends Request
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
            'category_id'=>'required|numeric',
            'name'=>'required|max:255',
            'status'=>'required|numeric',
            'sort_order'=>'numeric',
        ];
    }
}
