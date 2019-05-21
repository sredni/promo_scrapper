<?php

declare(strict_types=1);

namespace Sredni\Converter;

interface ConverterInterface
{
    /**
     * @param \SplFileInfo $file
     * @return \SplFileInfo
     */
    public function convert(\SplFileInfo $file): \SplFileInfo;
}