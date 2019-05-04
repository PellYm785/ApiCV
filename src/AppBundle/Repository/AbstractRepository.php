<?php
/**
 * Created by PhpStorm.
 * User: ngbamaw
 * Date: 30/12/18
 * Time: 23:23
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Knp\Component\Pager\Paginator;
use Pagerfanta\Pagerfanta;


abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $currentPage = 1)
    {
        if ($currentPage <= 0) {
            throw new \LogicException('La page doit être plus grande que 0');
        }

        $pager  = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage(10);

        return $pager;
    }
}