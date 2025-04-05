<?php

namespace App\Modules\Transaction\Repositories;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(TransferDTO $dto): Transaction
    {
        return Transaction::create([
            'payer_id' => $dto->payer,
            'payee_id' => $dto->payee,
            'value' => $dto->value,
        ]);
    }
}
