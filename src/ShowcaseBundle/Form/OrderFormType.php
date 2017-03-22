<?php

namespace ShowcaseBundle\Form;

use Common\Entity\Service;
use ShowcaseBundle\Entity\Form\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var Service $service
         */
        $service = $options['service'];
        $serviceModifications = $service->getServiceModifications();

        $builder
            ->add('secondName', TextType::class, ['label' => 'Фамилия'])
            ->add('firstName', TextType::class, ['label' => 'Имя'])
            ->add('middleName', TextType::class, ['label' => 'Отчество'])
            ->add('email', EmailType::class, ['label' => 'Электронная почта'])
            ->add('phone', TextType::class, ['label' => 'Телефон для связи'])
            ->add('otherContacts', TextareaType::class, ['label' => 'Другие контакты'])
            ->add('question', TextType::class, ['label' => 'Ваш вопрос'])
            ->add('description', TextareaType::class, ['label' => 'Подробное описание'])
            ->add('serviceModification', EntityType::class, [
                'label' => false, // лейбл определяется в order.html.twig, т.к. там нужно переопределять хитро блок
                'class' => 'Common\Entity\ServiceModification',
                'choices' => $serviceModifications,
                'choice_label' => function($serviceModification) {
                    $price = number_format($serviceModification->getPrice(), 0, '', '');
                    return $serviceModification->getName() . ' (' . $price . ' р.)';
                },
                'data' => $serviceModifications[0],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('isAgree', CheckboxType::class)
            ->add('uploadedFiles', FileType::class, [
                'label' => 'Добавьте файлы',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'service' => null,
        ]);
    }
}
