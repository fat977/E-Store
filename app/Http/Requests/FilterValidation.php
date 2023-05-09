<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterValidation extends FormRequest
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
            'cat_ids[]'=>'required',
            'filter_name'=>'required|regex:/^[a-zA-Z]*$/i|max:255|unique:product_filters',
            'filter_column'=>'required|regex:/^[a-zA-Z]*$/i|max:255|unique:product_filters',
        ];
    }

    public function onUpdate(){
        return [
            'cat_ids[]'=>'required',
            'filter_name'=>'required|regex:/^[a-zA-Z]*$/i|max:255',
            'filter_column'=>'required|regex:/^[a-zA-Z]*$/i|max:255',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('post') || request()->isMethod('patch') ?
        $this->onUpdate() : $this->onCreate();
    }

    public function messages(){
        return [
            'filter_column.regex' => 'Filter column must be string not allowed numbers!',
            'filter_name.regex' => 'Filter name must be string not allowed numbers!',
        ];
    }
}
