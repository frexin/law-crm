<?php

namespace AppBundle\Subscriber;

use AppBundle\Entity\OrderFile;
use AppBundle\Services\FileUploader;
use AppBundle\Services\FileUploaderInterface;
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

    public function __construct(FileUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate', 'postLoad'];
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

    /**
     * При редактировании форма будет ждать тип File,
     * но в бд сохраняется string с названием файла.
     * В этом методе мы переопределяем строку на File.
     *
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof OrderFile) {
            return;
        }

        if ($fileName = $entity->getFilePath()) {
            $entity->setFileObject(new File($this->uploader->getAbsoluteTargetDir().'/'.$fileName));
        }
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
        $entity->setName($file->getFilename());
    }
}