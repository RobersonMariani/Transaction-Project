<?php

namespace App\Modules\Transaction\DTOs;

class TransferDTO
{
    public function __construct(
        public int $payer,
        public int $payee,
        public float $value
    ) {}
}
