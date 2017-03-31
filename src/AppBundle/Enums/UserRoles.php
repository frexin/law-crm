<?php

namespace AppBundle\Enums;

class UserRoles extends BaseEnum
{
    const ROLE_CLIENT = 'ROLE_CLIENT';
    const ROLE_LAWYER = 'ROLE_LAWYER';
    const ROLE_SECRETARY = 'ROLE_SECRETARY';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    public static function getValues(): array
    {
        return [
             'Клиент' => self::ROLE_CLIENT,
             'Юрист' => self::ROLE_LAWYER,
             'Секретарь' => self::ROLE_SECRETARY,
             'Администратор' => self::ROLE_ADMIN,
        ];
    }

    public static function getAvailableRoles(): array
    {
        return [
            'Юрист' => self::ROLE_LAWYER,
            'Секретарь' => self::ROLE_SECRETARY,
            'Администратор' => self::ROLE_ADMIN,
        ];
    }
}