<?php

declare(strict_types=1);

namespace Sredni\Converter;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;

class VideoToAudioConverter implements ConverterInterface
{
    /**
     * @var FFMpeg
     */
    private $FFMpeg;

    /**
     * @var string
     */
    private $persistentPath;

    /**
     * @param FFMpeg $FFMpeg
     */
    public function __construct(FFMpeg $FFMpeg, string $persistentPath)
    {
        $this->FFMpeg = $FFMpeg;
        $this->persistentPath = $persistentPath;
    }

    /**
     * @param \SplFileInfo $file
     * @return \SplFileInfo
     */
    public function convert(\SplFileInfo $file): \SplFileInfo
    {
        $audioFileName = $file->getBasename('.mp4') . '.mp3';
        $audioFilePath = $this->persistentPath . DIRECTORY_SEPARATOR . $audioFileName;
        $video = $this->FFMpeg->open($file->getRealPath());

        $video->save(new Mp3(), $audioFilePath);

        return new \SplFileInfo($audioFilePath);
    }
}