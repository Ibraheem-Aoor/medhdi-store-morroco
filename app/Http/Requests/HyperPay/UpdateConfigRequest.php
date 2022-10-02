<?php

namespace App\Http\Requests\HyperPay;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->user_type == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hyper_id' => 'required',
            'hyper_key' => 'required',
            'mada_id' => 'required',
            'mada_key' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'hyper_id.required' => 'HYPER ENTITY ID REQUIRED',
            'mada_id.required' => 'MADA ENTITY ID REQUIRED',
            'hyper_key.required' => 'HYPER ENITITY REQUIRED',
            'mada_key.required' => 'MADA ENTITY KEY REQUIRED',
        ];
    }
}
