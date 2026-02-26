<?php

namespace App\Repository;

use App\Entity\NastaveniWebu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NastaveniWebu>
 */
class NastaveniWebuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NastaveniWebu::class);
    }

    public function findOneByIdentifikator(string $identifikator): ?NastaveniWebu
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.identifikator = :identifikator')
            ->setParameter('identifikator', $identifikator)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
