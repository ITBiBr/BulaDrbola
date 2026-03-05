<?php

namespace App\Twig;

use App\Entity\Clanky;
use App\Entity\MaterialyKategorie;
use App\Entity\NastaveniWebu;
use App\Entity\TextyStranek;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class GlobalVariables
{
    public function __construct(private EntityManagerInterface $entityManager, private SluggerInterface $slugger, private Security $security, private ParameterBagInterface $parameterBag)
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
    public function getNastaveniWebu(string $identifikator): ?string
    {
        $item = $this->entityManager
            ->getRepository(NastaveniWebu::class)
            ->findOneByIdentifikator($identifikator);

        return $item?->getNastaveni();
    }

    public function getClanekTitulek(string $url): ?string
    {
        $item = $this->entityManager
            ->getRepository(Clanky::class)
            ->findOneBy(['url' => $url]);

        return mb_strtolower($item?->getTitulek());
    }

    public function getMuzuZverejnit(): bool
    {
        $datumZverejneni = new \DateTimeImmutable(
            $this->parameterBag->get('datum_zverejneni')
        );

        $now = new \DateTimeImmutable();

        if ($now < $datumZverejneni  && !$this->security->isGranted('IS_AUTHENTICATED_FULLY')) { //muze se zverejnit nebo není user prihlasen
            return false;
        }
        return true;
    }

}