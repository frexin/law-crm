<?php

namespace AdminBundle\Admin;

use AdminBundle\Admin\Traits\OverloadedEntityTrait;
use AppBundle\Entity\Order;
use AppBundle\Entity\ServiceCategory;
use AppBundle\Enums\OrderStatuses;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

abstract class BaseOrderAdmin extends AbstractAdmin
{
    use OverloadedEntityTrait;

    protected $datagridValues = [
        '_sort_by' => 'createdAt',
    ];

    public function toString($object)
    {
        return $object instanceof Order
            ? $object->getTitle()
            : 'Дело'; // shown in the breadcrumb on the create view
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->add('send-message', 'send-message');
        $collection->add('download-file', 'download-file/{fileId}');
        $collection->add('upload-file', 'upload-file');
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
}