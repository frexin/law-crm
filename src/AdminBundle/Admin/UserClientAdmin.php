<?php

namespace AdminBundle\Admin;

use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserClientAdmin extends BaseUserAdmin
{
    protected function getBaseRoutePatternValue(): string
    {
        return 'user-client';
    }

    protected function getBaseRouteNameValue(): string
    {
        return 'admin_app_user_client';
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->add('select', 'm', false);
        $query->add('from', 'AppBundle\Entity\User m', false);

        $query->andWhere(
            $query->expr()->like('m.roles', '?1')
        );
        $query->setParameter('1', '%'.UserRoles::ROLE_CLIENT.'%');

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $help = $this->getHtmlForAvatar();

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

        $formMapper
            ->add('phone', null, [
                'label' => 'Телефон'
            ])
            ->add('otherContacts', TextareaType::class, [
                'label' => 'Другие контакты',
                'required' => false,
            ])
            ->add('isActive', 'checkbox', [
                'label' => 'Активен',
                'required' => false,
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Аватар',
                'help' => $help,
                'required' => false,
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
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

        $showMapper
            ->add('phone', null, [
                'label' => 'Телефон'
            ])
            ->add('otherContacts', TextareaType::class, [
                'label' => 'Другие контакты',
                'required' => false,
            ])
            ->add('isActive', null, [
                'label' => 'Активен',
                'required' => false,
            ])
            ->add('avatar', 'text', [
                'label' => 'Аватар',
                'template' => 'AdminBundle:overriden:picture.html.twig'
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstName', null, ['label' => 'Имя'])
            ->add('secondName', null, ['label' => 'Фамилия'])
            ->add('middleName', null, ['label' => 'Отчество'])
            ->add('email', null, ['label' => 'E-mail'])
            ->add('isActive', null, ['label' => 'Активен']);
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
            ->add('middleName', null, [
                'label' => 'Отчество',
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('isActive', null, [
                'label' => 'Активен'
            ])
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }
}