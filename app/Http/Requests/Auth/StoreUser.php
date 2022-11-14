<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'first_name'            => 'required|string',
            'last_name'             => 'required|string',
            'username'              => 'required|string',
            'email'                 => 'required|string',
            'password'              => 'required|string',
        ];
    }
}
