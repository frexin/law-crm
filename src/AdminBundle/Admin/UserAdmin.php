<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof User
            ? $object->getEmail()
            : 'Пользователь'; // shown in the breadcrumb on the create view
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->add('select', 'm', false );
        $query->add('from', 'AppBundle\Entity\User m', false );

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
            ->add('avatarUrl', null, [
                'label' => 'Аватар'
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstName')
            ->add('secondName')
            ->add('middleName')
            ->add('email');
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
//            ->add('imageUrl', null, [
//                'label' => 'URL изображения'
//            ])
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }
}