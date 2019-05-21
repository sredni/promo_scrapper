<?php

declare(strict_types=1);

namespace Sredni\Exception;

use Slim\Http\StatusCode;
use Throwable;

class InvalidTagException extends \Exception implements PublicExceptionInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $value, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function reason(): string
    {
        return 'invalid-tag';
    }

    /**
     * @return int
     */
    public function statusCode(): int
    {
        return StatusCode::HTTP_BAD_REQUEST;
    }


    /**
     * @return string
     */
    public function publicMessage(): string
    {
        return sprintf('Invalid tag value: `%s`', $this->value);
    }

    /**
     * @return mixed
     */
    public function publicData()
    {
        return null;
    }
}