<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceModification;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ServiceModificationAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_by' => 'service.title',
    ];

    public function toString($object)
    {
        return $object instanceof ServiceModification
            ? $object->getName()
            : 'Модификация услуги'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Информация', ['class' => 'col-md-9'])
            ->add('name', null, [
                'label' => 'Название'
            ])
            ->add('price', null, [
                'label' => 'Цена'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 8
                ],
                'label' => 'Описание'
            ])
            ->add('timeLimit', null, [
                'label' => 'Лимит времени'
            ])
            ->end()

            ->with('Услуга', ['class' => 'col-md-3'])
            ->add('service', 'sonata_type_model', [
                'class' => Service::class,
                'property' => 'title',
                'label' => 'Название услуги'
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'Название'])
            ->add('service', null, [
                'label' => 'Услуга'
            ], EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'title',
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, [
                'label' => 'Название'
            ])
            ->add('service.title', null, [
                'label' => 'Услуга'
            ])
            ->add('description', null, [
                'label' => 'Описание'
            ])
            ->add('timeLimit', null, [
                'label' => 'Лимит времени'
            ])
            ->add('price', null, [
                'label' => 'Цена'
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