<?php

declare(strict_types=1);

namespace Sredni\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\Http\Uri;
use Sredni\Exception\InvalidTagException;
use Sredni\Service\PromoScrapperService;
use Sredni\ValueObject\Tag;

class PromoController
{
    /**
     * @var PromoScrapperService
     */
    private $promoScrapperService;

    /**
     * @param PromoScrapperService $promoScrapperService
     */
    public function __construct(PromoScrapperService $promoScrapperService)
    {
        $this->promoScrapperService = $promoScrapperService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws InvalidTagException
     * @throws \Sredni\Exception\InvalidPromoResponseException
     */
    public function promoVideoToAudio(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $tag = new Tag($queryParams['tag'] ?? '');

        $convertedFileData = $this->promoScrapperService->fetchAndConvert($tag);

        return $response->withJson([
            $convertedFileData->serialize($this->getHostWithScheme($request->getUri()))
        ]);
    }

    /**
     * @param UriInterface $uri
     * @return string
     */
    private function getHostWithScheme(UriInterface $uri): string
    {
        return (string) new Uri($uri->getScheme(), $uri->getHost(), $uri->getPort());
    }
}