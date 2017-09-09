<?php
/**
 * Created by PhpStorm.
 * User: sks89
 * Date: 09.09.2017
 * Time: 0:17
 */

namespace AdminBundle\Admin;

use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FinanceAdmin extends AbstractAdmin
{
    protected function getBaseRoutePatternValue(): string
    {
        return 'finance';
    }

    protected function getBaseRouteNameValue(): string
    {
        return 'admin_app_finance';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('dt', 'datetime', [
                'format' => 'd-m-Y H:m',
                'label' => 'Дата платежа',
            ])
            ->add('user.fullName', null, [
                'label' => 'Плательщик',
            ])
            ->add('order.title', null, [
                'label' => 'Дело',
            ])
            ->add('amount', null, [
                'label' => 'Сумма',
            ])
            ->add('comment', null, [
                'label' => 'Комментарий',
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

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('amount', null, [
                'label' => 'Сумма'
            ])
            ->add('order', 'sonata_type_model', [
                'property' => 'title',
                'label' => 'Дело'
            ], ['admin_code' => 'admin.orders'])
            ->add('user', 'sonata_type_model', [
                'property' => 'fullName',
                'label' => 'Плательщик'
            ], ['admin_code' => 'admin.users'])
            ->add('comment', null, [
                'label' => 'Комментарий'
            ])
            ->add('isCache', 'hidden', [
                'data' => 1,
                'mapped' => false
            ]);
    }
}