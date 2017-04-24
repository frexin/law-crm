<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceModification;
use AppBundle\Entity\Order;
use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceModification;
use AppBundle\Entity\User;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\PaymentTypes;
use AppBundle\Enums\UserRoles;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
                    'label' => 'Юрист',
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

    protected function getUserQueryForRole($role)
    {
        $em = $this->modelManager->getEntityManager('AppBundle\Entity\User');

        return $em->createQueryBuilder('u')
            ->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.roles LIKE ?1')
            ->setParameter('1', '%'.$role.'%')
            ->getQuery();
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->id($this->getSubject())) {
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
                $formMapper->add('lawyer', EntityType::class, [
                    'label' => 'Юрист',
                    'placeholder' => '',
                    'empty_data'  => null,
                    'class' => User::class,
                    'choice_label' => 'fullName',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.roles LIKE ?1')
                            ->setParameter('1', '%'.UserRoles::ROLE_LAWYER.'%');
                    },
                ], ['admin_code' => 'admin.users']);
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
        } else {
            $formMapper
                ->with('Информация о деле', ['class' => 'col-md-9'])
                ->add('title', null, [
                    'label' => 'Название',
                ])
                ->add('description', null, [
                    'label' => 'Описание',
                ])
                ->add('status', HiddenType::class, [
                    'data' => OrderStatuses::STATUS_PAID,
                ])

                ->add('user', 'sonata_type_model', [
                    'label' => 'Клиент',
                    'placeholder' => '',
                    'empty_data'  => null,
                    'class' => User::class,
                    'property' => 'fullName',
                    'query' => $this->getUserQueryForRole(UserRoles::ROLE_CLIENT),
                ], ['admin_code' => 'admin.users.clients'])

                ->add('lawyer', EntityType::class, [
                    'label' => 'Юрист',
                    'placeholder' => '',
                    'empty_data'  => null,
                    'class' => User::class,
                    'choice_label' => 'fullName',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.roles LIKE ?1')
                            ->setParameter('1', '%'.UserRoles::ROLE_LAWYER.'%');
                    },
                    'required' => false,
                ], ['admin_code' => 'admin.users'])
                ->end();

            $formMapper
                ->with('Информация по услуге', ['class' => 'col-md-3'])
                    ->add('serviceModification', EntityType::class, [
                        'label' => 'Услуга',
                        'class' => ServiceModification::class,
                        'choice_label' => function ($serviceModification) {
                            return $serviceModification->getService()->getTitle() . ' ('.$serviceModification->getName().')';
                        }
                    ])
                ->end()

                ->with('Файлы к делу', ['class' => 'col-md-3'])
                    ->add('orderFiles', FileType::class, [
                        'multiple' => true,
                        'label' => 'Документы',
                        'required' => false,
                    ])
                ->end()

                ->with('Сроки', ['class' => 'col-md-3'])
                    ->add('startDate', 'sonata_type_datetime_picker', [
                        'format' => 'd-m-Y H:m',
                        'label' => 'Дата начала работы',
                        'required' => false,
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

    /**
     * @param Order $object
     */
    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $orderService = $container->get('app.sl.order');

        $amount = $object->getServiceModification()->getPrice();
        $orderService->createPaymentIssue($object->getId(), $amount, PaymentTypes::TYPE_CASH_PAYMENT);
    }
}