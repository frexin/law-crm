<?php

namespace AppBundle\Enums;

class OrderStatuses extends BaseEnum
{
    const STATUS_WAITING_PAYMENT = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_FINISHED = 3;
    const STATUS_CANCELED = 4;

    public static function getValues(): array
    {
        return [
            'STATUS_WAITING_PAYMENT' => self::STATUS_WAITING_PAYMENT,
            'STATUS_IN_PROGRESS' => self::STATUS_IN_PROGRESS,
            'STATUS_FINISHED' => self::STATUS_FINISHED,
            'STATUS_CANCELED' => self::STATUS_CANCELED,
        ];
    }
}