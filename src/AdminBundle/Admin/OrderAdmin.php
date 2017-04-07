<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Order;
use AppBundle\Entity\ServiceCategory;
use AppBundle\Entity\User;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_by' => 'createdAt',
    ];

    public function toString($object)
    {
        return $object instanceof Order
            ? $object->getTitle()
            : 'Дело'; // shown in the breadcrumb on the create view
    }

    public function getTemplate($name)
    {
        $roleChecker = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');

        if ($roleChecker->isGranted('ROLE_LAWYER') && $name === 'show') {
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

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->add('send-message', 'send-message');
        $collection->add('download-file', 'download-file/{fileId}');
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
    //                    'format' => 'dd-MM-yyyy HH:mm',
    //                    'dp_side_by_side' => true,
    //                    'required' => false,
    //                    'dp_use_current' => false,
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
                    'disabled'  => true,
                ])
                ->add('description', null, [
                    'label' => 'Описание',
                    'disabled'  => true,
                ])
                ->add('status', 'choice', [
                    'label' => 'Статус',
                    'choices' => OrderStatuses::getValues(),
                    'disabled'  => true,
                ])
                ->add('user.fullName', 'text', [
                    'label' => 'ФИО клиента',
                    'disabled'  => true,
                ]);

        if ($this->getSubject()->getLawyer()) {
            $formMapper->add('lawyer.fullName', 'text', [
                'label' => 'ФИО адвоката',
                'disabled'  => true,
            ]);
        } else {
            $formMapper->add('lawyer', 'sonata_type_model_autocomplete', [
                'class' => User::class,
                'property' => 'fullName',
                'label' => 'ФИО адвоката',
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
                    'disabled'  => true,
                ])
                ->add('endDate', 'sonata_type_datetime_picker', [
                    'format' => 'd-m-Y H:m',
                    'label' => 'Дата окончания работы',
                    'disabled'  => true,
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, [
                'label' => 'Название',
                'advanced_filter' => false
            ])
            ->add('status', null, [
                'label' => 'Статус',
                'advanced_filter' => false
            ], 'choice', [
                'choices' => OrderStatuses::getValues(),
            ])
            ->add('serviceModification.service.serviceCategory', null, [
                'label' => 'Категория',
                'advanced_filter' => false
            ], EntityType::class, [
                'class' => ServiceCategory::class,
                'choice_label' => 'title',
            ]);
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