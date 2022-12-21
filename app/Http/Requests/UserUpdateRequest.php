<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $user=$this->user;
        $rules = [
            'firstname'=>'required|max:30|alpha_spaces',
            'lastname'=>'required|max:30|alpha_spaces',
            'phone'=>'nullable|phone|min:10',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->route('id'))
            ],
            'road'=>'required|max:50',
            'postal_code' => 'required|postal_code:FR,UK',
            'city'=>'required|max:50'
        ];
        return $rules;
    }
}
