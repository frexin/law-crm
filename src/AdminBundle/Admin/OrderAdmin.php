<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrderAdmin extends BaseOrderAdmin
{
    protected function getBaseRoutePatternValue(): string
    {
        return 'order';
    }

    protected function getBaseRouteNameValue(): string
    {
        return 'admin_app_order';
    }

    public function getTemplate($name)
    {
        if ($name === 'show') {
            return 'AdminBundle:OrderAdmin:my-custom-show-for-admins.html.twig';
        }

        return parent::getTemplate($name);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
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

            ->with('Участники', ['class' => 'col-md-3'])
                ->add('user.fullName', null, [
                    'label' => 'Клиент',
                ])
                ->add('lawyer.fullName', null, [
                    'label' => '>Юрист',
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
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Информация о деле', ['class' => 'col-md-9'])
                ->add('id', null, [
                    'label' => 'Идентификатор',
                    'disabled'  => true,
                ])
                ->add('title', null, [
                    'label' => 'Название',
                ])
                ->add('description', null, [
                    'label' => 'Описание',
                ])
                ->add('status', 'choice', [
                    'label' => 'Статус',
                    'choices' => OrderStatuses::getValues(),
                ])
                ->add('user.fullName', 'text', [
                    'label' => 'ФИО клиента',
                    'disabled'  => true,
                ]);

        if ($this->getSubject()->getLawyer()) {
            $formMapper->add('lawyer.fullName', 'text', [
                'label' => 'ФИО юриста',
                'disabled'  => true,
            ]);
        } else {
            $formMapper->add('lawyer', 'sonata_type_model_autocomplete', [
                'class' => User::class,
                'property' => 'fullName',
                'label' => 'ФИО юриста',
                'required' => false,
                'to_string_callback' => function($entity, $property) {
                    return $entity->getFullName();
                },
                'callback' => function ($admin, $property, $value) {
                    $query = $admin->getDatagrid()->getQuery();

                    $query->andWhere($query->expr()->like('m.roles', '?1'));
                    $query->andWhere($query->expr()->like('m.fullName', '?2'));
                    $query->setParameter('1', '%'.UserRoles::ROLE_LAWYER.'%');
                    $query->setParameter('2', '%'.$value.'%');
                }
            ], [
                'admin_code' => 'admin.users'
            ]);
        }

        $formMapper
                ->add('recentActivity', 'sonata_type_datetime_picker', [
                    'label' => 'Последнее обновление',
                    'format' => 'd-m-Y H:m',
                    'disabled'  => true,
                ])
            ->end()

            ->with('Информация по услуге', ['class' => 'col-md-3'])
                ->add('serviceModification.service.serviceCategory.title', null, [
                    'label' => 'Категория',
                    'disabled'  => true,
                ])
                ->add('serviceModification.service.title', null, [
                    'label' => 'Услуга',
                    'disabled'  => true,
                ])
                ->add('serviceModification.name', null, [
                    'label' => 'Модификация',
                    'disabled'  => true,
                ])
            ->end()

            ->with('Сроки', ['class' => 'col-md-3'])
                ->add('createdAt', 'sonata_type_datetime_picker', [
                    'format' => 'd-m-Y H:m',
                    'label' => 'Дата создания',
                    'disabled'  => true,
                ])
                ->add('startDate', 'sonata_type_datetime_picker', [
                    'format' => 'd-m-Y H:m',
                    'label' => 'Дата начала работы',
                ])
                ->add('endDate', 'sonata_type_datetime_picker', [
                    'format' => 'd-m-Y H:m',
                    'label' => 'Дата окончания работы',
                ])
            ->end();
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
            ->add('lawyer.fullName', null, [
                'label' => 'ФИО юриста',
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
                ],
            ]);
    }
}