<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Enums\UserRoles;
use AppBundle\Services\FileUploader;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    /**
     * @var FileUploader
     */
    private $uploadService;
    /**
     * @var Packages
     */
    private $assetsHelper;

    public function __construct($code, $class, $baseControllerName, $uploadService, $assetsHelper)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->uploadService = $uploadService;
        $this->assetsHelper = $assetsHelper;
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getEmail()
            : 'Пользователь'; // shown in the breadcrumb on the create view
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->add('select', 'm', false);
        $query->add('from', 'AppBundle\Entity\User m', false);

        $query->andWhere(
            $query->expr()->orX(
                $query->expr()->like('m.roles', '?1'),
                $query->expr()->like('m.roles', '?2'),
                $query->expr()->like('m.roles', '?3')
            )
        );
        $query->setParameter('1', '%'.UserRoles::ROLE_LAWYER.'%');
        $query->setParameter('2', '%'.UserRoles::ROLE_SECRETARY.'%');
        $query->setParameter('3', '%'.UserRoles::ROLE_ADMIN.'%');

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {

        $image = $this->getSubject()->getAvatarUrl();

        if ($image) {
            $image = $this->assetsHelper->getUrl($this->uploadService->getPublicTargetDir().'/'.$image);
            $help = '<img src="'.$image.'" class="admin-preview" style="max-height:200px; max-width:200px"/>';
        } else {
            $help = '';
        }

        $formMapper
            ->add('secondName', null, [
                'label' => 'Фамилия'
            ])
            ->add('firstName', null, [
                'label' => 'Имя'
            ])
            ->add('middleName', null, [
                'label' => 'Отчество'
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ]);

        if ($this->id($this->getSubject())) {
            $formMapper->add('plainPassword', TextType::class, [
                'label' => 'Пароль',
                'required' => false,
            ]);
        } else {
            $formMapper->add('plainPassword', TextType::class, [
                'label' => 'Пароль',
            ]);
        }

        $formMapper
            ->add('phone', null, [
                'label' => 'Телефон'
            ])
            ->add('otherContacts', TextareaType::class, [
                'label' => 'Другие контакты',
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Роль',
                'choices' => UserRoles::getAvailableRoles(),
                'multiple' => true
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Аватар',
                'help' => $help,
                'required' => false,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstName')
            ->add('secondName')
            ->add('middleName')
            ->add('email')
            ->add('roles', null, [], 'choice', [
                'choices' => UserRoles::getAvailableRoles(),
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('secondName', null, [
                'label' => 'Фамилия'
            ])
            ->add('firstName', null, [
                'label' => 'Имя'
            ])
            ->add('middlename', null, [
                'label' => 'Отчество'
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('roles', 'array', [
                'label' => 'Роль'
            ])
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
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
}