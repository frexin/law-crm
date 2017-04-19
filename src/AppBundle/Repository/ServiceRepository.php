<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ServiceCategory;
use Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{
    /**
     * @param ServiceCategory $category
     * @return \AppBundle\Entity\Service[]
     */
    public function findByCategory(ServiceCategory $category)
    {
        return $this->createQueryBuilder('service')
            ->andWhere('service.serviceCategory = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->execute();
    }
}