<?php

namespace App\Modules\Transaction\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'payer' => 'required|exists:users,id',
            'payee' => 'required|exists:users,id|different:payer',
            'value' => 'required|numeric|min:0.01',
        ];
    }

    public function getPayer(): int
    {
        /** @var array{payer: int} $validated */
        $validated = $this->validated();

        return $validated['payer'];
    }

    public function getPayee(): int
    {
        /** @var array{payee: int} $validated */
        $validated = $this->validated();

        return $validated['payee'];
    }

    public function getValue(): float
    {
        /** @var array{value: float} $validated */
        $validated = $this->validated();

        return $validated['value'];
    }
}
