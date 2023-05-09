<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryValidation extends FormRequest
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
            'parent_id'=>  'required',
            'section_id'=>'required',
            'category_name'=>'required|regex:/^[a-zA-Z\s]+$/|max:255|unique:categories',
            'description'=>'required',
            'url'=>'required',
            'meta_title'=>'required',
            'meta_keywords'=>'required',
            'meta_description'=>'required',
        ];
    }

    public function onUpdate(){
        return [
            'parent_id'=>  'required',
            'section_id'=>'required',
            'category_name'=>'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'description'=>'required',
            'url'=>'required',
            'meta_title'=>'required',
            'meta_keywords'=>'required',
            'meta_description'=>'required',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('post') || request()->isMethod('patch') ?
        $this->onUpdate() : $this->onCreate();
    }

    public function messages(){
        return [
            'category_name.regex' => 'Category name must be string not allowed numbers!',
        ];
    }
}
