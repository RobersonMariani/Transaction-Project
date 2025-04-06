<?php

namespace App\Modules\Transaction\Repositories;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Cria uma nova transação.
     *
     * @param TransferDTO $dto
     * @return Transaction
     */
    public function create(TransferDTO $dto): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::create([
            'payer_id' => $dto->payer,
            'payee_id' => $dto->payee,
            'value'    => $dto->value,
        ]);

        return $transaction;
    }
}
