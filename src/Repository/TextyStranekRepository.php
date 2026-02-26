<?php

namespace App\Repository;

use App\Entity\TextyStranek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TextyStranek>
 */
class TextyStranekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextyStranek::class);
    }

    public function findOneByIdentifikatorAndStranka(string $identifikator, string $stranka): ?TextyStranek
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.identifikator = :identifikator')
            ->andWhere('t.stranka = :stranka')
            ->setParameter('identifikator', $identifikator)
            ->setParameter('stranka', $stranka)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
