<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProduct extends FormRequest
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
            'web_quota' => 'required|integer',
            'db_quota' => 'required|integer',
            'flow_limit' => 'required|integer',
            'db_type' => ['required', Rule::in(['mysql', 'sqlsrv'])],
            'domain' => 'required|integer',
            'subdir_flag' => 'required|boolean',
            'subdir_max' => 'required|integer',
            'ftp' => 'required|boolean',
            'ftp_connect' => 'required|integer',
            'ftp_usl' => 'required|integer',
            'ftp_dsl' => 'required|integer',
            'htaccess' => 'boolean',
            'log_handle' => 'boolean',
            'access' => 'boolean',
            'speed_limit' => 'required|integer',
            'account_limit' => 'required|integer'
        ];
    }
}
