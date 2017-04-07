<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file);
    public function getAbsoluteTargetDir(): string;
    public function getPublicTargetDir(): string;
}