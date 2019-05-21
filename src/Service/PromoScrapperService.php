<?php

declare(strict_types=1);

namespace Sredni\Service;

use Sredni\Converter\ConverterInterface;
use Sredni\Crawler\CrawlerInterface;
use Sredni\DTO\ConvertedFileData;
use Sredni\DTO\PromoVideoData;
use Sredni\Exception\InvalidPromoResponseException;
use Sredni\ValueObject\PublicFile;
use Sredni\ValueObject\Tag;

class PromoScrapperService
{
    /**
     * @var CrawlerInterface
     */
    private $crawler;

    /**
     * @var ConverterInterface
     */
    private $converter;

    /**
     * @var string
     */
    private $promoUrlPattern;

    /**
     * @param CrawlerInterface $crawler
     * @param ConverterInterface $converter
     * @param string $promoUrlPattern
     */
    public function __construct(CrawlerInterface $crawler, ConverterInterface $converter, string $promoUrlPattern)
    {
        $this->crawler = $crawler;
        $this->converter = $converter;
        $this->promoUrlPattern = $promoUrlPattern;
    }

    /**
     * @param Tag $tag
     * @return ConvertedFileData
     * @throws InvalidPromoResponseException
     */
    public function fetchAndConvert(Tag $tag): ConvertedFileData
    {
        $searchResponse = $this->crawler->fetchJson(sprintf($this->promoUrlPattern, $tag->value()));
        $videoData = $this->extractVideoData($searchResponse);
        $videoFile = $this->crawler->fetchFile($videoData->videoUrl());
        $audioFile = $this->converter->convert($videoFile);

        return new ConvertedFileData(
            new PublicFile($audioFile),
            $videoData->videoId()
        );
    }

    /**
     * @param $searchResponse
     * @return PromoVideoData
     * @throws InvalidPromoResponseException
     */
    private function extractVideoData($searchResponse): PromoVideoData
    {
        $video = array_shift($searchResponse['response']['body']['videos']);

        if (!$video) {
            throw new InvalidPromoResponseException('No videos found');
        }

        $video = array_pop($video['videos']);

        if (!$video) {
            throw new InvalidPromoResponseException('No videos found');
        }

        return new PromoVideoData($video['previewUrl'], $video['videoId']);
    }
}