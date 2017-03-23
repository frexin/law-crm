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
        $formMapper->add('title', 'text', [
            'label' => 'Название'
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label' => 'Название',
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