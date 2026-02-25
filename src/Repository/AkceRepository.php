<?php

namespace App\Repository;

use App\Entity\Akce;
use App\Entity\Stitky;
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

    public function findAkceKZobrazeniPaginated(int $limit, int $offset, ?Stitky $stitek = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.DatumZobrazeniOd <= CURRENT_TIMESTAMP()')
            ->andWhere('
                a.DatumDo >= CURRENT_DATE()
                OR (a.DatumDo IS NULL AND a.Datum >= CURRENT_DATE())
            ')
            ->orderBy('a.Datum', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        if ($stitek) {
            $qb->innerJoin('a.stitkies', 's')
                ->andWhere('s.id = :stitek')
                ->setParameter('stitek', $stitek->getId());
        }

        return $qb->getQuery()->getResult();
    }
}
