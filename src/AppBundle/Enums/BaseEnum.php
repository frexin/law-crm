<?php

namespace AppBundle\Enums;

abstract class BaseEnum
{
    abstract public static function getValues(): array;

    public static function exists($value): bool
    {
        $values = static::getValues();
        return array_key_exists($value, $values);
    }
}