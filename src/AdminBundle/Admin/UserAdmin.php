<?php

namespace AdminBundle\Admin;

use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends BaseUserAdmin
{
    protected function getBaseRoutePatternValue(): string
    {
        return 'user';
    }

    protected function getBaseRouteNameValue(): string
    {
        return 'admin_app_user';
    }

    public function createQuery($context = 'list')
    {
        $roleChecker = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');
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

        // немного костыльно, но запрещаем секретарю видеть администриатора
        if ($roleChecker->isGranted(UserRoles::ROLE_SECRETARY)) {
            $query->setParameter('3', '%'.UserRoles::ROLE_LAWYER.'%');
        } else {
            $query->setParameter('3', '%'.UserRoles::ROLE_ADMIN.'%');
        }

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
            ->add('roles', 'choice', [
                'label' => 'Роль',
                'choices' => UserRoles::getAvailableRoles(),
                'multiple' => true
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
            ->add('rolesString', null, [
                'label' => 'Роль',
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
            ->add('roles', null, [
                'label' => 'Роль'
            ], 'choice', [
                'choices' => UserRoles::getAvailableRoles(),
            ])
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
                'label' => 'Отчество'
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('rolesString', null, [
                'label' => 'Роль'
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