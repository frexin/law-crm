<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ServiceCategory;
use Doctrine\ORM\EntityRepository;

class ServiceCategoryRepository extends EntityRepository
{
    /**
     * @return ServiceCategory[]
     */
    public function findAllAvailable()
    {
        return $this->createQueryBuilder('category')
            ->andWhere('category.isAvailable = :available')
            ->setParameter('available', 1)
            ->getQuery()
            ->execute();
    }
}