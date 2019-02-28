<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveServer extends FormRequest
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
            'sname' => 'required|max:100',
            'ip' => 'required|ipv4',
            'port' => 'required|numeric|between:1, 65535',
            'user' => 'required|max:100',
            'pass' => 'required|max:100',
            'authcode' => 'required|max:100',
        ];
    }
}
