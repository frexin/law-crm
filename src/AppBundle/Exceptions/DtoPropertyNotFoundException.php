<?php

namespace AppBundle\Exceptions;

class DtoPropertyNotFoundException extends \Exception
{
    public function __construct($propertyName)
    {
        $message = 'Попытка получить в DTO несуществующее свойство: '.$propertyName;
        parent::__construct($message);
    }
}