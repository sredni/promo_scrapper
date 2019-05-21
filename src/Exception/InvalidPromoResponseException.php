<?php

declare(strict_types=1);

namespace Sredni\Exception;

use Slim\Http\StatusCode;

class InvalidPromoResponseException extends \Exception implements InternalExceptionInterface
{
    /**
     * @return string
     */
    public function reason(): string
    {
        return 'promo-response-exception';
    }

    /**
     * @return int
     */
    public function statusCode(): int
    {
        return StatusCode::HTTP_INTERNAL_SERVER_ERROR;
    }
}