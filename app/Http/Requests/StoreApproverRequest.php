<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApproverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:approvers,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama approver wajib diisi.',
            'name.unique' => 'Nama approver sudah terdaftar, harap gunakan nama lain.',
        ];
    }
}
