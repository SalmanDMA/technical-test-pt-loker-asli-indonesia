<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Jumlah pengeluaran wajib diisi.',
            'amount.integer' => 'Jumlah pengeluaran harus berupa angka bulat.',
            'amount.min' => 'Jumlah pengeluaran harus lebih dari atau sama dengan 1.',
        ];
    }
}
