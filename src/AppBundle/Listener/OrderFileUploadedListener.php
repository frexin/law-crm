<?php

namespace AppBundle\Listener;

use AppBundle\Events\OrderFileUploaded;
use AppBundle\ServiceLayer\OrderService;
use Symfony\Component\Routing\RouterInterface;

class OrderFileUploadedListener
{
    private $orderService;
    private $router;

    public function __construct(OrderService $orderService, RouterInterface $router)
    {
        $this->orderService = $orderService;
        $this->router = $router;
    }

    public function onOrderFileUploaded(OrderFileUploaded $event)
    {
        $file = $event->getFile();
        $user = $event->getUser();
        $downloadUrl = $this->router->generate('admin_app_order_lawyer_download-file', [
            'fileId' => $file->getId(),
        ]);

        $message = '<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                   <span class="center_fio">'.$user->getFullName().'</span> добавил документ: 
                   <span class="center_file"><a href="'.$downloadUrl.'">'.$file->getName().'</a></span>';

        $this->orderService->createMessage($user, $file->getOrder(), $message, true);
    }
}