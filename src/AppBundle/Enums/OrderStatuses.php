<?php

namespace AppBundle\Enums;

class OrderStatuses
{
    const STATUS_WAITING_PAYMENT = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_FINISHED = 3;
    const STATUS_CANCELED = 4;
}