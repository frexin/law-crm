<?php

namespace AppBundle\Enums;

class PaymentTypes extends BaseEnum
{
    const TYPE_YANDEX_PAYMENT = 1;

    public static function getValues(): array
    {
        return [
            'Яндекс.Деньги' => self::TYPE_YANDEX_PAYMENT,
        ];
    }
}