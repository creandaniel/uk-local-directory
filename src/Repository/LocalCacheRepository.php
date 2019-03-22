<?php

namespace App\Repository;

use App\Entity\LocalCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LocalCache|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocalCache|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocalCache[]    findAll()
 * @method LocalCache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalCacheRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LocalCache::class);
    }

    // /**
    //  * @return LocalCache[] Returns an array of LocalCache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LocalCache
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
