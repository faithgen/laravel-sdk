<?php

namespace FaithDen\SDK\Tests;

use InnoFlash\LaraStart\Traits\ExceptionsTrait;
use Orchestra\Testbench\Exceptions\Handler;
use Throwable;

class ErrorHandler extends Handler
{
    use ExceptionsTrait;

    public function render($request, Throwable $e)
    {
        return $this->apiExceptions($request, $e);
    }
}
