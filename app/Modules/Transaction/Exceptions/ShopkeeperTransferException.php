<?php

namespace App\Modules\Transaction\Exceptions;

use RuntimeException;

/**
 * Class ShopkeeperTransferException
 *
 * This exception is thrown when a shopkeeper attempts to transfer funds.
 *
 * @package App\Modules\Transaction\Exceptions
 */
class ShopkeeperTransferException extends RuntimeException
{
    public function __construct(string $message = 'Shopkeepers are not allowed to transfer funds.', int $code = 403)
    {
        parent::__construct($message, $code);
    }
}
