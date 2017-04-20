<?php

namespace AppBundle\Enums;

class OrderStatuses extends BaseEnum
{
    const STATUS_WAITING_PAYMENT = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_FINISHED = 3;
    const STATUS_CANCELED = 4;
    const STATUS_PAID = 5;

    public static function getValues(): array
    {
        return [
            'Ждет оплаты' => self::STATUS_WAITING_PAYMENT,
            'Оплачен' => self::STATUS_PAID,
            'В работе' => self::STATUS_IN_PROGRESS,
            'Выполнен' => self::STATUS_FINISHED,
            'Отменен' => self::STATUS_CANCELED,
        ];
    }
}