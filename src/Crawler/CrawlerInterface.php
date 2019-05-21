<?php

declare(strict_types=1);

namespace Sredni\Crawler;

interface CrawlerInterface
{
    /**
     * @param string $url
     * @return \SplFileInfo
     */
    public function fetchFile(string $url): \SplFileInfo;

    /**
     * @param string $url
     * @return array
     */
    public function fetchJson(string $url): array;
}