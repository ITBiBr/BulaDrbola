<?php

namespace App\Controller\Twig;

use App\Entity\Materialy;
use App\Entity\MaterialyKategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class GlobalVariables
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly SluggerInterface $slugger)
    {

    }
    public function getKategorieData(): array{
        $kategorie = $this->entityManager->getRepository(MaterialyKategorie::class)->findAll();
        $kategorieData = [];
        foreach ($kategorie as $kat) {
            $kategorieData[] = [
                'id' => $kat->getId(),
                'Kategorie' => $kat->getKategorie(),
                'slug' => $this->slugger->slug($kat->getKategorie())->lower(),
                'materialies' => $kat->getMaterialies(),
            ];
        }
        return $kategorieData;
    }

}