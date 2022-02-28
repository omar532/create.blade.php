<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

        public function rules()
    {
        $id = $this->user->id;
        return $rules = [
            'username' => 'required|max:30|alpha|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id
        ];
    }


}