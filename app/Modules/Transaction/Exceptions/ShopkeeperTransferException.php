<?php

namespace App\Modules\Transaction\Exceptions;

use RuntimeException;

class ShopkeeperTransferException extends RuntimeException
{
    public function __construct(string $message = 'Shopkeepers are not allowed to transfer funds.', int $code = 403)
    {
        parent::__construct($message, $code);
    }
}
