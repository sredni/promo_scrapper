<?php

declare(strict_types=1);

namespace Sredni\Crawler;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Sredni\Exception\CrawlerException;
use Sredni\Exception\CrawlerWrongResponseCodeException;

class PromoCrawler implements CrawlerInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $temporaryPath;

    /**
     * @param Client $client
     * @param string $temporaryPath
     */
    public function __construct(Client $client, string $temporaryPath)
    {
        $this->client = $client;
        $this->temporaryPath = $temporaryPath;
    }

    /**
     * @param string $url
     * @return \SplFileInfo
     * @throws CrawlerException
     * @throws \Exception
     */
    public function fetchFile(string $url): \SplFileInfo
    {
        $filePath = $this->temporaryPath . DIRECTORY_SEPARATOR . base64_encode(random_bytes(9)) . '.mp4';
        $response = $this->client->get($url, [
            RequestOptions::SINK => $filePath,
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new CrawlerException(sprintf('Unable to crawl url: `%s` status code: `%s`', $url, $response->getStatusCode()));
        }

//        register_shutdown_function(function () use ($filePath) {
//            @unlink($filePath);
//        });

        return new \SplFileInfo($filePath);
    }

    /**
     * @param string $url
     * @return array
     * @throws CrawlerException
     */
    public function fetchJson(string $url): array
    {
        $response = $this->client->get($url);

        if ($response->getStatusCode() !== 200) {
            throw new CrawlerException(sprintf('Unable to crawl url: `%s` status code: `%s`', $url, $response->getStatusCode()));
        }

        $content = $response->getBody()->getContents();

        return \GuzzleHttp\json_decode($content, true);
    }
}