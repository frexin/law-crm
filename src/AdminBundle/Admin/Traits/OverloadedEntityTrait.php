<?php

namespace AdminBundle\Admin\Traits;

trait OverloadedEntityTrait
{
    abstract protected function getBaseRoutePatternValue(): string;
    abstract protected function getBaseRouteNameValue(): string;

    public function __construct($code, $class, $baseControllerName)
    {
        $this->baseRoutePattern = $this->getBaseRoutePatternValue();
        $this->baseRouteName = $this->getBaseRouteNameValue();
        parent::__construct($code, $class, $baseControllerName);
    }
}