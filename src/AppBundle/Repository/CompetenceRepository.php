<?php
/**
 * Created by PhpStorm.
 * User: ngbamaw
 * Date: 30/12/18
 * Time: 23:48
 */

namespace AppBundle\Repository;


class CompetenceRepository extends AbstractRepository
{
    public function search($term, $order = 'asc', $currentPage)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c');
            //->orderBy('c.nom',$order);

        if ($term) {
            $qb
                ->where('c.nom LIKE :keyword')
                ->setParameter('keyword', '%'.$term.'%')
            ;
        }


        return $this->paginate($qb, $currentPage);
    }

}