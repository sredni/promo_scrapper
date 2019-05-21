<?php

declare(strict_types=1);

namespace Sredni\DTO;

use Sredni\ValueObject\PublicFile;

class ConvertedFileData
{
    /**
     * @var PublicFile
     */
    private $audioFile;

    /**
     * @var string
     */
    private $videoId;

    /**
     * @param PublicFile $audioFile
     * @param string $videoId
     */
    public function __construct(PublicFile $audioFile, string $videoId)
    {
        $this->audioFile = $audioFile;
        $this->videoId = $videoId;
    }

    /**
     * @return array
     */
    public function serialize(string $urlPrefix): array
    {
        return [
            'videoId' => $this->videoId,
            'downloadUrl' => $this->audioFile->publicFilePath($urlPrefix),
        ];
    }
}