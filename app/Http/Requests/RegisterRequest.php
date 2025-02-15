<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'email' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.emails.required'),
            'email.unique' => trans('validation.emails.unique'),
            'password' => trans('validation.password'),
            'name' => trans('validation.name')
        ];
    }
}