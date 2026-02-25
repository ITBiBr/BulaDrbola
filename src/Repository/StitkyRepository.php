<?php

namespace App\Repository;

use App\Entity\Stitky;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stitky>
 */
class StitkyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stitky::class);
    }

    public function findStitkySPlatnymiAkcemi(bool $probehle = false): array
    {
        $qb = $this->createQueryBuilder('s')
            ->innerJoin('s.Akce', 'a');
        if ($probehle) {
            $qb->where('
                    a.DatumDo < CURRENT_DATE()
                    OR (a.DatumDo IS NULL AND a.Datum < CURRENT_DATE())
                ');
        } else {
            $qb->where('a.DatumZobrazeniOd <= CURRENT_TIMESTAMP()')
                ->andWhere('
                    a.DatumDo >= CURRENT_DATE()
                    OR (a.DatumDo IS NULL AND a.Datum >= CURRENT_DATE())
                ');
        }
        $qb->groupBy('s.id')
            ->orderBy('s.Titulek', 'ASC');
        return $qb->getQuery()->getResult();
    }
}
