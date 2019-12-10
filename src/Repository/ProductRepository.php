<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function lastRelease(){

        $query = $this->createQueryBuilder('p')
                        ->orderBy('p.createdAt', 'DESC')
                        ->setMaxResults(20);

        return $query->getQuery()->getResult();
    }

    public function getProductsCount($producer)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->andWhere('p.producer = :producer')
            ->setParameter('producer', $producer)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAllWithSearchQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.producer', 'pr')
            ->addSelect('pr')
            ->join('p.subcategories', 's')
            ->addSelect('s')
        ;

        if ($term) {
            $qb->andWhere('p.name LIKE :term OR pr.firstname LIKE :term OR pr.lastname LIKE :term')
                ->setParameter('term', '%'.$term.'%')
            ;
        }

        return $qb;
    }

    public function getProductsWithoutTheOneDisplayed($id)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.producer', 'pr')
            ->addSelect('pr')
            ->andWhere('p.id != :id')
            ->setParameter('id', $id)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}
