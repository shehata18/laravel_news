<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:70|unique:users,username',
            'email' => 'required|email',
            'phone'=>'required|unique:users,phone',
            'status'=>'required|in:1,0',
            'email_verified_at'=>'in:1,0',
            'country'=>'required|string|min:3|max:30',
            'city'=>'required|string|min:3|max:30',
            'street'=>'required|string|min:3|max:300',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',


        ];
    }
}
