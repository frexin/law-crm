<?php

namespace AdminBundle\Forms;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleEventForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => 'AppBundle:ScheduleEventType',
                'choice_label' => 'name',
                'label' => 'Тип события',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание',
                'attr' => [
                    'placeholder' => 'Встреча с клиентом'
                ],
            ])
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Время',
                'attr' => [
                    'placeholder' => 'Выберите дату и время'
                ],
            ]);
    }
}
