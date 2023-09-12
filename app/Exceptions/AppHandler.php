<?php

namespace App\Exceptions;

use Error;

class AppHandler extends Error
{

    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
