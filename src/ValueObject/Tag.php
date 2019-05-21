<?php

declare(strict_types=1);

namespace Sredni\ValueObject;

use Sredni\Exception\InvalidTagException;

class Tag
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     * @throws InvalidTagException
     */
    public function __construct(string $value)
    {
        if (strlen($value) <= 0) {
            throw new InvalidTagException($value);
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}