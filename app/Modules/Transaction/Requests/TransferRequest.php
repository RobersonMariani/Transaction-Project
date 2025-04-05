<?php

namespace App\Modules\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payer' => 'required|exists:users,id',
            'payee' => 'required|exists:users,id|different:payer',
            'value' => 'required|numeric|min:0.01',
        ];
    }
}
