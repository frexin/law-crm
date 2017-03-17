<?php

namespace ShowcaseBundle\Twig\Extension;

use Doctrine\ORM\EntityManagerInterface;

/**
 * TODO если хелпер не понадобится - удалить его удалить коммент в конфиге сервисов
 *
 * Class ShowcaseViewHelper
 * @package ShowcaseBundle\Twig\Extension
 */
class ShowcaseViewHelper extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getName()
    {
        return 'showcase_view_helper';
    }

    public function getFunctions()
    {
        return [];
    }
}
