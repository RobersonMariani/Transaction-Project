<?php

namespace App\Modules\Transaction\Exceptions;

use RuntimeException;

class InsufficientBalanceException extends RuntimeException
{
    public function __construct(string $message = 'Insufficient balance.', int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
