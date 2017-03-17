<?php

namespace ShowcaseBundle\Twig\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use ShowcaseBundle\Entity\Service;

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

    public function getServiceMinPrice(Service $service)
    {
        $price = $this->em->createQueryBuilder()
            ->select('sm.price')
            ->from('ShowcaseBundle\Entity\ServiceModification', 'sm')
            ->leftJoin('sm.service', 's')
            ->where('sm.service = :service')
            ->setParameter('service', $service)
            ->orderBy('sm.price', 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->execute();

        $price = $price[0]['price'] ?? null;

        if (!$price) {
            throw new NoResultException('Для сервиса не найдена ни одна модификация. Ошибка целостности данных');
        }

        return $price;
    }

    public function getFunctions()
    {
        return [
            'getPrice' => new \Twig_SimpleFunction('getServiceMinPrice', [$this, 'getServiceMinPrice']),
        ];
    }
}
