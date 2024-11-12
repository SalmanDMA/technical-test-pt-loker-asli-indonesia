<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApprovalStageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'approver_id' => 'required|exists:approvers,id|unique:approval_stages,approver_id',
        ];
    }

    public function messages()
    {
        return [
            'approver_id.required' => 'ID approver wajib diisi.',
            'approver_id.exists' => 'ID approver tidak ditemukan di tabel approvers.',
            'approver_id.unique' => 'ID approver sudah ada di tahap approval, harap pilih yang lain.',
        ];
    }
}
