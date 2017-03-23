<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceCategory;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ServiceAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof Service
            ? $object->getTitle()
            : 'Категория услуг'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Информация', ['class' => 'col-md-9'])
                ->add('title', null, [
                    'label' => 'Название'
                ])
                ->add('shortDescription', null, [
                    'label' => 'Короткое описание'
                ])
                ->add('description', TextareaType::class, [
                    'attr' => [
                        'rows' => 8
                    ],
                    'label' => 'Описание'
                ])
                ->add('imageUrl', null, [
                    'label' => 'URL изображения'
                ])
            ->end()

            ->with('Категория', ['class' => 'col-md-3'])
                ->add('serviceCategory', 'sonata_type_model', [
                    'class' => ServiceCategory::class,
                    'property' => 'title',
                    'label' => 'Категория услуг'
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('serviceCategory', null, [], EntityType::class, [
                'class' => ServiceCategory::class,
                'choice_label' => 'title',
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label' => 'Название'
            ])
            ->add('shortDescription', null, [
                'label' => 'Короткое описание'
            ])
            ->add('serviceCategory.title', null, [
                'label' => 'Категория'
            ])
            ->add('imageUrl', null, [
                'label' => 'URL изображения'
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