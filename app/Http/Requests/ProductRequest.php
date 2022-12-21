<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'product_name'=>'required|min:3|max:255', 
            'category_id'=>'required|numeric',
            'img'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
            'product_price'=>'required_without:product_total_price|nullable|numeric',
            'product_total_price'=>'required_without:product_price|nullable|numeric',
            'product_weight'=>'required|numeric',
            'description'=>'required',
        ];

        return $rules;
    }
}
