<?php

declare(strict_types=1);

namespace Sredni\Response;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use Sredni\Exception\InternalExceptionInterface;
use Sredni\Exception\PublicExceptionInterface;

class ResponseFormatMiddleware
{
    /**
     * @var bool
     */
    private $debug;

    /**
     * @param bool $debug
     */
    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        $responseBody = null;
        $responseStatus = null;

        try {
            /** @var Response $response */
            $response = $next($request, $response);
        } catch (PublicExceptionInterface $exception) {
            $responseStatus = $exception->statusCode();
            $responseBody = [
                'error' => [
                    'reason' => $exception->reason(),
                    'message' => $exception->publicMessage(),
                    'data' => $exception->publicData(),
                ]
            ];
        } catch (InternalExceptionInterface $exception) {
            $responseStatus = $exception->statusCode();
            $responseBody = [
                'error' => [
                    'reason' => $exception->reason(),
                ]
            ];
        } catch (\Throwable $exception) {
            $responseStatus = StatusCode::HTTP_INTERNAL_SERVER_ERROR;
            $responseBody = [
                'error' => [
                    'reason' => 'internal-server-error',
                ]
            ];
        }

        if (!empty($exception)) {
            if ($this->debug) {
                $responseBody = $this->addDebug($responseBody, $exception);
            }

            $response = $response->withJson(
                $responseBody,
                $responseStatus
            );
        }

        return $response;
    }

    /**
     * @param array $responseBody
     * @param \Throwable $exception
     * @return array
     */
    private function addDebug(array $responseBody, \Throwable $exception): array
    {
        $responseBody['debug'] = [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
        ];

        return $responseBody;
    }
}