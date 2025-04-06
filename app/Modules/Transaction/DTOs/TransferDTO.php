<?php

namespace App\Modules\Transaction\DTOs;

/**
 * DTO responsável por carregar os dados de uma transferência.
 */
readonly class TransferDTO
{
    public function __construct(
        public int $payer,
        public int $payee,
        public float $value
    ) {}
}
