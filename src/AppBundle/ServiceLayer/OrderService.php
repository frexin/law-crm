<?php

namespace AppBundle\ServiceLayer;

use AppBundle\DTO\SavedFileDto;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderChatMessage;
use AppBundle\Entity\OrderFile;
use AppBundle\Entity\OrderPaymentInfo;
use AppBundle\Entity\PrivateOrderComment;
use AppBundle\Entity\User;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\UserRoles;
use AppBundle\Events\OrderFormSubmitted;
use AppBundle\Services\ContractCreator;
use AppBundle\Services\FileDownloaderInterface;
use AppBundle\Services\FileUploaderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OrderService extends BaseService
{
    protected $em;
    protected $fileDownloader;
    protected $fileUploader;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(EntityManagerInterface $em, FileDownloaderInterface $fileDownloader,
                                FileUploaderInterface $fileUploader, ContainerInterface $container)
    {
        $this->em = $em;
        $this->fileDownloader = $fileDownloader;
        $this->fileUploader = $fileUploader;
        $this->container = $container;
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

    public function changeStatus($orderId, $status)
    {
        $order = $this->getModelById($orderId, 'AppBundle:Order');
        $order->setStatus($status);
        $this->em->persist($order);
        $this->em->flush();
    }

    public function createPaymentIssue($orderId, $amount, $type, $isMoneyback = false)
    {
        $order = $this->getModelById($orderId, 'AppBundle:Order');

        $orderPayment = new OrderPaymentInfo();
        $orderPayment->setOrder($order);
        $orderPayment->setAmount($amount);
        $orderPayment->setPaymentType($type);
        $orderPayment->setIsMoneyback($isMoneyback);

        $this->em->persist($orderPayment);
        $this->em->flush();
    }

    public function createAndSendContract($orderId)
    {
        $order = $this->getModelById($orderId, 'AppBundle:Order');

        /**
         * @var ContractCreator $contractCreator
         */
        $contractCreator = $this->container->get('app.contract_creator');
        $contractCreator->fillFromOrder($order);

        $filename = uniqid() . '.docx';
        $path = $this->container->getParameter('documents_upload_directory') . DIRECTORY_SEPARATOR . $filename;

        if ($contractCreator->downloadSignedContract($path)) {
            $uploadedFile = new UploadedFile($path, $filename);

            $orderFile = new OrderFile();
            $orderFile->setName($uploadedFile->getClientOriginalName());
            $orderFile->setOrder($order);
            $orderFile->setFilePath($filename);

            $this->em->persist($orderFile);
            $this->em->flush();

            $event = new OrderFormSubmitted($order->getUser(), $order, $path);
            $this->container->get('event_dispatcher')->dispatch('app.event.user_success_payment', $event);
        }
    }

    public function addPrivateMessage($orderId, $userId, $message)
    {
        $user = $this->getModelById($userId, 'AppBundle:User');

        $commentModel = new PrivateOrderComment();
        $commentModel->setOrder($this->getModelById($orderId, 'AppBundle:Order'));
        $commentModel->setIsFromLawyer($user->hasRole(UserRoles::ROLE_LAWYER));
        $commentModel->setText($message);

        $this->em->persist($commentModel);
        $this->em->flush();
    }
}