<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFollow extends FormRequest
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
//            'message' => [
//                'required',
//                'string',
//                'max:400'
//            ],
            'follower_id' => [
                'required',
                'exists:App\Models\User,id',
                'unique:follows,follower_id,' . $this->follower_id . ',id,followed_id,' . $this->followed_id
            ],
//            'followed_id' => [
//                'required',
//                'exists:App\Models\User,id'
//            ],
        ];
    }

    public function messages()
    {
        return [
            'follower_id.unique' => 'fueron tomados'
        ];
    }

}
