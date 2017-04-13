<?php

namespace AdminBundle\Admin;

use AdminBundle\Admin\Traits\OverloadedEntityTrait;
use AppBundle\Entity\User;
use AppBundle\Services\FileUploaderInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Asset\Packages;

abstract class BaseUserAdmin extends AbstractAdmin
{
    use OverloadedEntityTrait{
        OverloadedEntityTrait::__construct as private __traitConstruct;
    }

    /**
     * @var FileUploaderInterface
     */
    protected $uploadService;
    /**
     * @var Packages
     */
    protected $assetsHelper;

    public function __construct($code, $class, $baseControllerName, FileUploaderInterface $uploadService, $assetsHelper)
    {
        $this->uploadService = $uploadService;
        $this->assetsHelper = $assetsHelper;
        $this->__traitConstruct($code, $class, $baseControllerName);
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getEmail()
            : 'Пользователь'; // shown in the breadcrumb on the create view
    }

    /**
     * @param User $user
     */
    public function prePersist($user)
    {
        $this->uploadAvatar($user);
    }

    /**
     * @param User $user
     */
    public function preUpdate($user)
    {
        $this->uploadAvatar($user);
    }

    protected function uploadAvatar(User $user)
    {
        if (!$user->getAvatar()) {
            return;
        }

        $fileName = $this->uploadService->upload($user->getAvatar());
        $user->setAvatarUrl($fileName);
        $user->setAvatar(null);
    }

    protected function getHtmlForAvatar(): string
    {
        $image = $this->getSubject()->getAvatarUrl();

        if ($image) {
            $image = $this->assetsHelper->getUrl($this->uploadService->getPublicTargetDir().'/'.$image);
            $help = '<img src="'.$image.'" class="admin-preview" style="max-height:200px; max-width:200px"/>';
        } else {
            $help = '';
        }

        return $help;
    }
}