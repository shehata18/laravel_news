<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'digits_between:10,15'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string', 'min:10', 'max:500'],

        ];
    }
}
