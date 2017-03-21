<?php

namespace AppBundle\Subscriber;

use AppBundle\Entity\OrderFile;
use AppBundle\Services\FileUploader;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OrderFileUploadSubscriber implements EventSubscriber
{
    /**
     * @var FileUploader
     */
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate', 'postLoad'];
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof OrderFile) {
            return;
        }

        if ($fileName = $entity->getFilePath()) {
            $entity->setFilePath(new File($this->uploader->getTargetDir().'/'.$fileName));
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $this->uploadFile($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof OrderFile) {
            return;
        }

        $file = $entity->getFilePath();

        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setFilePath($fileName);
    }
}