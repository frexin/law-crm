<?php

namespace AppBundle\ServiceLayer;

use AppBundle\DTO\SavedFileDto;
use AppBundle\Entity\OrderChatMessage;
use AppBundle\Entity\OrderFile;
use AppBundle\Entity\User;
use AppBundle\Enums\UserRoles;
use AppBundle\Services\FileDownloaderInterface;
use AppBundle\Services\FileUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OrderService extends BaseService
{
    protected $em;
    protected $fileDownloader;
    protected $fileUploader;

    public function __construct(EntityManagerInterface $em, FileDownloaderInterface $fileDownloader, FileUploaderInterface $fileUploader)
    {
        $this->em = $em;
        $this->fileDownloader = $fileDownloader;
        $this->fileUploader = $fileUploader;
    }

    /**
     * Если $notification = true, значит это уведомление, например о загрузке документа в дело.
     * В таком случае у сообщения нет адресата, есть только отправитель.
     *
     * @param User $userFrom
     * @param $orderId
     * @param $message
     * @param bool $notification
     */
    public function createMessage(User $userFrom, $orderId, $message, $notification = false)
    {
        $order = $this->getModelById($orderId, 'AppBundle:Order');

        if (!$notification) {
            if (array_search(UserRoles::ROLE_LAWYER, $userFrom->getRoles()) !== false) {
                $userTo = $order->getUser();
            } else {
                $userTo = $order->getLawyer();
            }
        } else {
            $userTo = null;
        }

        $messageModel = new OrderChatMessage();
        $messageModel->setText($message);
        $messageModel->setUserFrom($userFrom);
        $messageModel->setUserTo($userTo);
        $messageModel->setOrder($order);

        $this->em->persist($messageModel);
        $this->em->flush();
    }

    public function getResponseWithFile($id)
    {
        $file = $this->getModelById($id, 'AppBundle:OrderFile');
        $fileDto = new SavedFileDto($file);

        return $this->fileDownloader->getDownloadResponse($fileDto);
    }

    public function uploadOrderFile(UploadedFile $file, $orderId)
    {
        $order = $this->getModelById($orderId, 'AppBundle:Order');
        $fileName = $this->fileUploader->upload($file);

        $orderFile = new OrderFile();
        $orderFile->setName($file->getClientOriginalName());
        $orderFile->setOrder($order);
        $orderFile->setFilePath($fileName);

        $this->em->persist($orderFile);
        $this->em->flush();

        return $orderFile;
    }
}