<?php

namespace App\Modules\Transaction\Repositories;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Models\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * Cria uma nova transação.
     *
     * @param TransferDTO $dto
     * @return Transaction
     */
    public function create(TransferDTO $dto): Transaction;
}
