<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'email'=>  'required|email',
            'password'=> ['required'],
        ];
    }

    public function messages(){
        return [
            'email.required' => 'We need to know your email address!',
            'password' => 'Password is required',
        ];
    }
}
