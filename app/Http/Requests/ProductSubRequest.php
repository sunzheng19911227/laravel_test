<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductSubRequest extends Request
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
            'product_id'=>'required',
            'productNo'=>'required|unique:product_sub',
            'price'=>'required|numeric',
            'sale_price'=>'required|numeric',
            'sort_order'=>'numeric',
            'file'=>'image',
        ];
    }
}
