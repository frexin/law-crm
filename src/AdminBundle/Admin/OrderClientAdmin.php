<?php

namespace AdminBundle\Admin;

use AppBundle\Enums\OrderStatuses;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrderClientAdmin extends BaseOrderAdmin
{
    protected function getBaseRoutePatternValue(): string
    {
        return 'order-client';
    }

    protected function getBaseRouteNameValue(): string
    {
        return 'admin_app_order_client';
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

        $query->add('select', 'o', false);
        $query->add('from', 'AppBundle\Entity\Order o', false);
        $query->andWhere($query->expr()->eq('o.user', '?1'));
        $query->setParameter('1', $user);

        return $query;
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

            ->with('Ваш юрист', ['class' => 'col-md-3'])
                ->add('lawyer.fullName', null, [
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
            ->add('createdAt', 'datetime', [
                'format' => 'd-m-Y H:m',
                'label' => 'Дата создания'
            ])
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'show' => [],
                ],
            ]);
    }
}