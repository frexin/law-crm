<?php

namespace AppBundle\ServiceLayer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseService
 *
 * @property EntityManagerInterface $em
 * @package AppBundle\ServiceLayer
 */
abstract class BaseService
{
    protected function getModelById($id, $repositoryName)
    {
        $model = $this->em->getRepository($repositoryName)->find($id);

        if (!$model) {
            throw new NotFoundHttpException('В репозитории '.$repositoryName.' не найден файл с id= ' . $id);
        }

        return $model;
    }
}