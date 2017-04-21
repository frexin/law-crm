<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrderLawyerAdmin extends BaseOrderAdmin
{
    protected function getBaseRoutePatternValue(): string
    {
        return 'order-lawyer';
    }

    protected function getBaseRouteNameValue(): string
    {
        return 'admin_app_order_lawyer';
    }

    protected function getRemovedActions(): array
    {
        return ['create'];
    }

    public function getTemplate($name)
    {
        if ($name === 'show') {
            return 'AdminBundle:OrderAdmin:my-custom-show.html.twig';
        }

        return parent::getTemplate($name);
    }

    public function createQuery($context = 'list')
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $query = parent::createQuery($context);

        if (!$user->isActive()) {
            // такой вот костылик, чтобы не показывать список дел
            $query->andWhere('o.id = -1');
            return $query;
        }

        if ($user->hasRole(UserRoles::ROLE_LAWYER)) {
            $query->add('select', 'o', false);
            $query->add('from', 'AppBundle\Entity\Order o', false);

            $query->andWhere($query->expr()->eq('o.lawyer', '?1'));
            $query->setParameter('1', $user);
        }

        return $query;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $roleChecker = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');

        if ($roleChecker->isGranted('ROLE_LAWYER')) {
            $showMapper
                ->with('Информация о деле', ['class' => 'col-md-3'])
                    ->add('id', null, [
                        'label' => 'Идентификатор'
                    ])
                    ->add('title', null, [
                        'label' => 'Название'
                    ])
                    ->add('description', null, [
                        'label' => 'Описание',
                    ])
                    ->add('status', 'choice', [
                        'label' => 'Статус',
                        'choices' => array_flip(OrderStatuses::getValues()),
                    ])
                    ->add('createdAt', 'datetime', [
                        'format' => 'd-m-Y H:m',
                        'label' => 'Дата создания',
                    ])
            ->end()

            ->with('Ваш клиент', ['class' => 'col-md-3'])
                ->add('user.fullName', null, [
                    'label' => 'ФИО',
                ])
            ->end()

            ->with('Информация по услуге', ['class' => 'col-md-3'])
                ->add('serviceModification.service.serviceCategory.title', null, [
                    'label' => 'Категория',
                ])
                ->add('serviceModification.service.title', null, [
                    'label' => 'Услуга',
                ])
                ->add('serviceModification.name', null, [
                    'label' => 'Модификация',
                ])
            ->end();
        } else {
            $showMapper
                ->with('Информация о деле', ['class' => 'col-md-9'])
                    ->add('id', null, [
                        'label' => 'Идентификатор'
                    ])
                    ->add('title', null, [
                        'label' => 'Название'
                    ])
                    ->add('description', null, [
                        'label' => 'Описание',
                    ])
                    ->add('status', 'choice', [
                        'label' => 'Статус',
                        'choices' => array_flip(OrderStatuses::getValues()),
                    ])
                    ->add('user.fullName', null, [
                        'label' => 'ФИО клиента',
                    ])
                    ->add('lawyer.fullName', null, [
                        'label' => 'ФИО адвоката',
                    ])
                    ->add('recentActivity', null, [
                        'label' => 'Последнее обновление',
                        'format' => 'd-m-Y H:m',
                    ])
                ->end()

                ->with('Информация по услуге', ['class' => 'col-md-3'])
                    ->add('serviceModification.service.serviceCategory.title', null, [
                        'label' => 'Категория',
                    ])
                    ->add('serviceModification.service.title', null, [
                        'label' => 'Услуга',
                    ])
                    ->add('serviceModification.name', null, [
                        'label' => 'Модификация',
                    ])
                ->end()

                ->with('Сроки', ['class' => 'col-md-3'])
                    ->add('createdAt', 'datetime', [
                        'format' => 'd-m-Y H:m',
                        'label' => 'Дата создания',
                    ])
                    ->add('startDate', 'datetime', [
                        'format' => 'd-m-Y H:m',
                        'label' => 'Дата начала работы',
                    ])
                    ->add('endDate', 'datetime', [
                        'format' => 'd-m-Y H:m',
                        'label' => 'Дата окончания работы',
                    ])
                ->end();
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label' => 'Название',
            ])
            ->add('status', 'choice', [
                'label' => 'Статус',
                'choices' => array_flip(OrderStatuses::getValues())
            ])
            ->add('serviceModification.service.serviceCategory.title', null, [
                'label' => 'Категория',
            ])
            ->add('serviceModification.service.title', null, [
                'label' => 'Услуга',
            ])
            ->add('serviceModification.name', null, [
                'label' => 'Модификация',
            ])
            ->add('user.fullName', null, [
                'label' => 'ФИО клиента',
            ])
            ->add('createdAt', 'datetime', [
                'format' => 'd-m-Y H:m',
                'label' => 'Дата создания'
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