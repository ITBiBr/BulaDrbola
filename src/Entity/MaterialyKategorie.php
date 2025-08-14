<?php

namespace App\Entity;

use App\Repository\MaterialyKategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialyKategorieRepository::class)]
class MaterialyKategorie
{
    public function __toString(): string
    {
         return $this->getKategorie();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Kategorie = null;

    /**
     * @var Collection<int, Materialy>
     */
    #[ORM\ManyToMany(targetEntity: Materialy::class, mappedBy: 'Kategorie')]
    private Collection $materialies;

    public function __construct()
    {
        $this->materialies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKategorie(): ?string
    {
        return $this->Kategorie;
    }

    public function setKategorie(string $Kategorie): static
    {
        $this->Kategorie = $Kategorie;

        return $this;
    }

    /**
     * @return Collection<int, Materialy>
     */
    public function getMaterialies(): Collection
    {
        return $this->materialies;
    }

    public function addMaterialy(Materialy $materialy): static
    {
        if (!$this->materialies->contains($materialy)) {
            $this->materialies->add($materialy);
            $materialy->addKategorie($this);
        }

        return $this;
    }

    public function removeMaterialy(Materialy $materialy): static
    {
        if ($this->materialies->removeElement($materialy)) {
            $materialy->removeKategorie($this);
        }

        return $this;
    }
}
