<?php

namespace AppBundle\Services;

use AppBundle\DTO\SavedFileDto;
use Symfony\Component\HttpFoundation\Response;

class FileDownloader implements FileDownloaderInterface
{
    public function getDownloadResponse(SavedFileDto $savedFile, Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }

        $response->headers->set('Content-Type', $savedFile->mimeType);
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$savedFile->fileName);
        $response->setContent($savedFile->content);

        return $response;
    }
}