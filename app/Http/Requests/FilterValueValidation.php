<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterValueValidation extends FormRequest
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
    public function onCreate(){
        return [
            'filter_id'=>'required',
            'filter_value'=>'required|max:255|unique:product_filter_values',
        ];
    }

    public function onUpdate(){
        return [
            'filter_id'=>'required',
            'filter_value'=>'required|max:255',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('post') || request()->isMethod('patch') ?
        $this->onUpdate() : $this->onCreate();
    }

    public function messages(){
        return [
            'filter_value.regex' => 'Filter column must be string not allowed numbers!',

        ];
    }
}
