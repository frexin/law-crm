<?php

namespace AppBundle\Enums;

class PaymentTypes extends BaseEnum
{
    const TYPE_YANDEX_PAYMENT = 1;
    const TYPE_CASH_PAYMENT = 2;

    public static function getValues(): array
    {
        return [
            'Яндекс.Деньги' => self::TYPE_YANDEX_PAYMENT,
            'Наличные' => self::TYPE_CASH_PAYMENT,
        ];
    }
}