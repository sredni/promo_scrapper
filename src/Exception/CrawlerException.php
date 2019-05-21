<?php

declare(strict_types=1);

namespace Sredni\Exception;

use Slim\Http\StatusCode;

class CrawlerException extends \Exception implements InternalExceptionInterface
{
    /**
     * @return string
     */
    public function reason(): string
    {
        return 'crawler-exception';
    }

    /**
     * @return int
     */
    public function statusCode(): int
    {
        return StatusCode::HTTP_INTERNAL_SERVER_ERROR;
    }
}