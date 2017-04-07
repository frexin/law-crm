<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader implements FileUploaderInterface
{
    private $absoluteTargetDir;
    private $webTargetDir;

    public function __construct(string $absoluteTargetDir, string $webTargetDir)
    {
        $this->absoluteTargetDir = $absoluteTargetDir;
        $this->webTargetDir = $webTargetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->absoluteTargetDir, $fileName);

        return $fileName;
    }

    public function getAbsoluteTargetDir(): string
    {
        return $this->absoluteTargetDir;
    }

    public function getPublicTargetDir(): string
    {
        return $this->webTargetDir;
    }
}