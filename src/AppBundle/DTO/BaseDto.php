<?php

namespace AppBundle\DTO;

use AppBundle\Exceptions\DtoPropertyNotFoundException;

abstract class BaseDto
{
    public function __get($name)
    {
        if (!isset($this->{$name})) {
            throw new DtoPropertyNotFoundException($name);
        }

        return $this->{$name};
    }
}