<?php

declare(strict_types=1);

namespace Sredni\Exception;

interface InternalExceptionInterface extends \Throwable
{
    /**
     * @return string
     */
    public function reason(): string;

    /**
     * @return int
     */
    public function statusCode(): int;
}