<?php

namespace AppBundle\Enums;

abstract class BaseEnum
{
    abstract public static function getRoles(): array;

    public static function exists($role): bool
    {
        $roles = static::getRoles();
        return array_key_exists($role, $roles);
    }
}