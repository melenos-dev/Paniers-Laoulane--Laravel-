<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productCatRequest extends FormRequest
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
        $rules = [];
        //$rules['name'] = 'required|min:3|max:255|unique:products_cat,name,NULL,id,parent_id,0';
        $rules['name'] = 'required|min:3|max:255';
        return $rules;
    }
}
