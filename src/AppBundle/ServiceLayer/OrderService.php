<?php

namespace AppBundle\ServiceLayer;

use AppBundle\DTO\SavedFileDto;
use AppBundle\Entity\OrderChatMessage;
use AppBundle\Entity\User;
use AppBundle\Enums\UserRoles;
use AppBundle\Services\FileDownloaderInterface;
use Doctrine\ORM\EntityManagerInterface;

class OrderService extends BaseService
{
    protected $em;
    protected $fileDownloader;

    public function __construct(EntityManagerInterface $em, FileDownloaderInterface $fileDownloader)
    {

        $this->em = $em;
        $this->fileDownloader = $fileDownloader;
    }

    public function createMessage(User $userFrom, $orderId, $message)
    {
        $order = $this->getModelById($orderId, 'AppBundle:Order');

        if (array_search(UserRoles::ROLE_LAWYER, $userFrom->getRoles()) !== false) {
            $userTo = $order->getUser();
        } else {
            $userTo = $order->getLawyer();
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
}