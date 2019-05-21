<?php

declare(strict_types=1);

namespace Sredni\DTO;

class PromoVideoData
{
    /**
     * @var string
     */
    private $videoUrl;

    /**
     * @var string
     */
    private $videoId;

    /**
     * @param string $videoUrl
     * @param string $videoId
     */
    public function __construct(string $videoUrl, string $videoId)
    {
        $this->videoUrl = $videoUrl;
        $this->videoId = $videoId;
    }

    /**
     * @return string
     */
    public function videoUrl(): string
    {
        return $this->videoUrl;
    }

    /**
     * @return string
     */
    public function videoId(): string
    {
        return $this->videoId;
    }
}