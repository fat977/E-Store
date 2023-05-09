<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerValidation extends FormRequest
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
            'image'=> 'required|mimes:jpg,jpeg|unique:banners',
            'type'=>'required',
            'title'=>'required',
            'link'=>'required',
            'alt'=>'required',
        ];
    }

    public function onUpdate(){
        return [
            'image'=> 'required|mimes:jpg,jpeg',
            'type'=>'required',
            'title'=>'required',
            'link'=>'required',
            'alt'=>'required',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('post') || request()->isMethod('patch') ?
        $this->onUpdate() : $this->onCreate();
    }

    public function messages(){
        return [
            'image.unique' => 'Banner Image must be unique!',
        ];
    }
}
