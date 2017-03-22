<?php

namespace AppBundle\Enums;

class UserRoles extends BaseEnum
{
    const ROLE_CLIENT = 'ROLE_CLIENT';
    const ROLE_LAWYER = 'ROLE_LAWYER';
    const ROLE_SECRETARY = 'ROLE_SECRETARY';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    public static function getRoles(): array
    {
        return [
            self::ROLE_CLIENT => 'ROLE_CLIENT',
            self::ROLE_LAWYER => 'ROLE_LAWYER',
            self::ROLE_SECRETARY => 'ROLE_SECRETARY',
            self::ROLE_ADMIN => 'ROLE_ADMIN',
        ];
    }
}