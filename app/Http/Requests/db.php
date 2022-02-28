<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class db extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:30|alpha|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ];
    }

}
