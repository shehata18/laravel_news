<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => [ 'required', 'string', 'min:4', 'max:60' ],
            'username' => [ 'required', 'unique:users,username,' . auth()->id()],
            'email' => [ 'required', 'string', 'email', 'unique:users,email,' . auth()->id() ],
            'phone' => [ 'required', 'numeric', 'digits_between:9,15', 'unique:users,phone,' . auth()->id()],
            'country' => [ 'required', 'string', 'min:3', 'max:60' ],
            'city' => [ 'required', 'string', 'min:3', 'max:60' ],
            'street' => [ 'required', 'string', 'min:3', 'max:60' ],
            'image' => [ 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048' ],
        ];
    }

}
