<?php

namespace RestaurantBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CompanyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyRepository extends \Doctrine\ORM\EntityRepository
{
	public function getFilterCompany($name) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
                ->from('RestaurantBundle:Company', 'c');
        $qb->where('c.name like :name')
                ->setParameters(array('name'=>'%'.$name.'%'));
        $entites = $qb->getQuery()->getResult();
        return $entites;
    }
    public function getAllCompanies($limit,$page)
    {
            $qb = $this->_em->createQueryBuilder();
            $qb->select('c')
                ->from('RestaurantBundle:Company', 'c');
            $qb->where('c.id > 1');
            $offset=$page*$limit;
            $entites = $qb->getQuery()->setMaxResults($limit)->setFirstResult($offset)->getResult();
            return $entites;
    }

    public function getCountCompanies(){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(c.id)');
        $qb->from('RestaurantBundle:Company','c');
        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
}
