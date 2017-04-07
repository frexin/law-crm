<?php

namespace AppBundle\Services;

use AppBundle\DTO\SavedFileDto;
use Symfony\Component\HttpFoundation\Response;

interface FileDownloaderInterface
{
    public function getDownloadResponse(SavedFileDto $savedFile, Response $response = null);
}