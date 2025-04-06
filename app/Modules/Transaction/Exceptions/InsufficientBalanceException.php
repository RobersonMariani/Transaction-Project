<?php

namespace App\Modules\Transaction\Exceptions;

use RuntimeException;

/**
 * Class InsufficientBalanceException
 *
 * This exception is thrown when a user attempts to transfer more funds than they have available.
 *
 * @package App\Modules\Transaction\Exceptions
 */
class InsufficientBalanceException extends RuntimeException
{
    public function __construct(string $message = 'Insufficient balance.', int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
