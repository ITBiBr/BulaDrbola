<?php

namespace App\Repository;

use App\Entity\Akce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Akce>
 */
class AkceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Akce::class);
    }

    public function findAkceKZobrazeniPaginated(int $limit, int $offset): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.DatumZobrazeniOd < :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('a.Datum', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
