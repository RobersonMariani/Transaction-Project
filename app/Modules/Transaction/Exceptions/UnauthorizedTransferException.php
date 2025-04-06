<?php

namespace App\Modules\Transaction\Exceptions;

use RuntimeException;

/**
 * Class UnauthorizedTransferException
 *
 * This exception is thrown when a transfer is not authorized by an external service.
 *
 * @package App\Modules\Transaction\Exceptions
 */
class UnauthorizedTransferException extends RuntimeException
{
    public function __construct(string $message = 'Transfer not authorized by external service.', int $code = 403)
    {
        parent::__construct($message, $code);
    }
}
