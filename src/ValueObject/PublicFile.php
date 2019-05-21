<?php

declare(strict_types=1);

namespace Sredni\ValueObject;

class PublicFile
{
    /**
     * @var \SplFileInfo
     */
    private $splFileInfo;

    /**
     * @param \SplFileInfo $splFileInfo
     */
    public function __construct(\SplFileInfo $splFileInfo)
    {
        $this->splFileInfo = $splFileInfo;
    }

    /**
     * @param string $prefix
     * @return string
     */
    public function publicFilePath(string $prefix = ''): string
    {
        return $prefix . 'file/' . $this->splFileInfo->getBasename();
    }
}