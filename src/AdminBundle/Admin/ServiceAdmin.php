<?php

namespace AdminBundle\Admin;

use AppBundle\Entity\Service;
use AppBundle\Entity\ServiceCategory;
use AppBundle\Services\FileUploader;
use AppBundle\Services\FileUploaderInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServiceAdmin extends AbstractAdmin
{
    /**
     * @var FileUploader
     */
    private $uploadService;
    /**
     * @var Packages
     */
    private $assetsHelper;

    public function __construct($code, $class, $baseControllerName, FileUploaderInterface $uploadService, $assetsHelper)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->uploadService = $uploadService;
        $this->assetsHelper = $assetsHelper;
    }

    public function toString($object)
    {
        return $object instanceof Service
            ? $object->getTitle()
            : 'Услуга'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject()->getImageUrl();

        if ($image) {
            $image = $this->assetsHelper->getUrl($this->uploadService->getPublicTargetDir().'/'.$image);
            $help = '<img src="'.$image.'" class="admin-preview" style="max-height:200px; max-width:200px"/>';
        } else {
            $help = '';
        }

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
                ->add('image', 'file', [
                    'label' => 'Изображение',
                    'help' => $help,
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

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
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
                    'label' => 'Изображение',
                    'template' => 'AdminBundle:overriden:picture.html.twig'
                ])
            ->end()

            ->with('Категория', ['class' => 'col-md-3'])
                ->add('serviceCategory', ModelType::class, [
                    'class' => ServiceCategory::class,
                    'associated_property' => 'title',
                    'label' => 'Категория услуг'
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, ['label' => 'Название'])
            ->add('serviceCategory', null, [
                'label' => 'Категория'
            ], EntityType::class, [
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
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    /**
     * @param Service $service
     */
    public function prePersist($service)
    {
        $this->uploadImage($service);
    }

    /**
     * @param Service $service
     */
    public function preUpdate($service)
    {
        $this->uploadImage($service);
    }

    protected function uploadImage(Service $service)
    {
        if (!$service->getImage()) {
            return;
        }

        $fileName = $this->uploadService->upload($service->getImage());
        $service->setImageUrl($fileName);
        $service->setImage(null);
    }
}