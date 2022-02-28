<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest {

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