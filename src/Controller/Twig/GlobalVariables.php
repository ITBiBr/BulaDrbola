<?php

namespace App\Controller\Twig;

use App\Entity\Materialy;
use App\Entity\MaterialyKategorie;
use App\Entity\TextyStranek;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class GlobalVariables
{
    public function __construct(private EntityManagerInterface $entityManager, private SluggerInterface $slugger)
    {

    }
    public function getKategorieData(): array{
        $kategorie = $this->entityManager->getRepository(MaterialyKategorie::class)->findAll();
        $kategorieData = [];
        foreach ($kategorie as $kat) {
            $materialies = $kat->getMaterialies()->toArray();

            // Seřazení podle Nazev vzestupně
            $collator = new \Collator('cs_CZ'); // české řazení
            usort($materialies, function($a, $b) use ($collator) {
                return $collator->compare($a->getNazev(), $b->getNazev());
            });
            $kategorieData[] = [
                'id' => $kat->getId(),
                'Kategorie' => $kat->getKategorie(),
                'slug' => $this->slugger->slug($kat->getKategorie())->lower(),
                'materialies' => $materialies,
            ];
        }
        return $kategorieData;
    }

    public function getTextyStranek(string $identifikator, string $stranka): ?string
    {
        $item = $this->entityManager
            ->getRepository(TextyStranek::class)
            ->findOneByIdentifikatorAndStranka($identifikator, $stranka);

        return $item?->getText();
    }
    public function getNadpisTextuStranek(string $identifikator, string $stranka): ?string
    {
        $item = $this->entityManager
            ->getRepository(TextyStranek::class)
            ->findOneByIdentifikatorAndStranka($identifikator, $stranka);

        return $item?->getNadpis();
    }

}