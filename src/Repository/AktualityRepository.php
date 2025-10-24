<?php

namespace App\Repository;

use App\Entity\Aktuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aktuality>
 */
class AktualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aktuality::class);
    }

    //    /**
    //     * @return Aktuality[] Returns an array of Aktuality objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Aktuality
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findAktualityKZobrazeni(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.DatumZobrazeniOd < :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('a.Datum', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAktualityKZobrazeniPaginated(int $limit, int $offset): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.DatumZobrazeniOd < :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('a.Datum', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
