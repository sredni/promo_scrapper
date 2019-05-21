<?php

declare(strict_types=1);

namespace Sredni\Exception;

interface PublicExceptionInterface extends InternalExceptionInterface
{
    /**
     * @return string
     */
    public function publicMessage(): string;

    /**
     * @return mixed
     */
    public function publicData();
}