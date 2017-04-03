<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\ServiceCategory;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ServiceCategoryAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof ServiceCategory
            ? $object->getTitle()
            : 'Категория'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', [
                'label' => 'Название'
            ])
            ->add('isAvailable', 'checkbox', [
                'label' => 'Доступно на сайте',
                'required' => false
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, [
                'label' => 'Название'
            ])
            ->add('isAvailable', 'doctrine_orm_boolean', [
                'label' => 'Доступно на сайте'
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label' => 'Название',
            ])
            ->add('isAvailable', null, [
                'label' => 'Доступно на сайте',
            ])
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }
}