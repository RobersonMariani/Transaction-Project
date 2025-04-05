<?php

namespace App\Modules\Transaction\Exceptions;

use RuntimeException;

class UnauthorizedTransferException extends RuntimeException
{
    public function __construct(string $message = 'Transfer not authorized by external service.', int $code = 403)
    {
        parent::__construct($message, $code);
    }
}
