<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'firstname'=>'required|max:30|alpha_spaces',
            'lastname'=>'required|max:30|alpha_spaces',
            'phone'=>'nullable|phone|min:10',
            'email'=>'required|email|max:255|unique:users',
            'password'=>'required|min:6',
            'road'=>'required|max:50',
            'postal_code' => 'required|postal_code:FR,UK',
            'city'=>'required|max:50'
        ];
        return $rules;
    }
}
