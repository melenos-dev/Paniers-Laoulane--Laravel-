<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'firstname'=>'required|min:3|max:20|alpha_spaces',
            'lastname'=>'required|min:3|max:20|alpha_spaces',
            'email'=>'required|email',
            'msg'=>'required|max:250'
        ];
    }
}
