<?php

namespace App\Modules\Transaction\Repositories;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create(TransferDTO $dto): Transaction;
}
