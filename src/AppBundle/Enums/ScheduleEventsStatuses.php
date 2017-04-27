<?php

namespace AppBundle\Enums;

class ScheduleEventsStatuses extends BaseEnum
{
    const STATUS_WAITING = 1;
    const STATUS_FINISHED = 2;
    const STATUS_CANCELED = 3;

    public static function getValues(): array
    {
        return [
            'Ожидание' => self::STATUS_WAITING,
            'Выполнено' => self::STATUS_FINISHED,
            'Отменено' => self::STATUS_CANCELED,
        ];
    }
}