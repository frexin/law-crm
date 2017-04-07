<?php

namespace AppBundle\DTO;

use AppBundle\Entity\OrderFile;

/**
 * Class SavedFileDto
 *
 * @property $mimeType
 * @property $fileName
 * @property $content
 *
 * @package AppBundle\DTO
 */
class SavedFileDto extends BaseDto
{
    protected $mimeType;
    protected $fileName;
    protected $content;

    public function __construct(OrderFile $file)
    {

        $fullPath = $file->getFileObject()->getPathname();

        $this->mimeType = $file->getFileObject()->getMimeType();
        $this->fileName = $file->getName();
        $this->content = @file_get_contents($fullPath);
    }
}