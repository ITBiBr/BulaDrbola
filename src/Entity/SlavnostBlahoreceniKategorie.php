<?php

namespace App\Entity;

use App\Repository\SlavnostBlahoreceniKategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SlavnostBlahoreceniKategorieRepository::class)]
class SlavnostBlahoreceniKategorie
{
    public function __toString(): string
    {
        return $this->getNazevKategorie();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NazevKategorie = null;

    /**
     * @var Collection<int, SlavnostBlahoreceniTexty>
     */
    #[ORM\OneToMany(targetEntity: SlavnostBlahoreceniTexty::class, mappedBy: 'Kategorie')]
    #[ORM\OrderBy(['priorita' => 'DESC'])]
    private Collection $slavnostBlahoreceniTexties;

    public function __construct()
    {
        $this->slavnostBlahoreceniTexties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazevKategorie(): ?string
    {
        return $this->NazevKategorie;
    }

    public function setNazevKategorie(string $NazevKategorie): static
    {
        $this->NazevKategorie = $NazevKategorie;

        return $this;
    }

    /**
     * @return Collection<int, SlavnostBlahoreceniTexty>
     */
    public function getSlavnostBlahoreceniTexties(): Collection
    {
        return $this->slavnostBlahoreceniTexties;
    }

    public function addSlavnostBlahoreceniTexty(SlavnostBlahoreceniTexty $slavnostBlahoreceniTexty): static
    {
        if (!$this->slavnostBlahoreceniTexties->contains($slavnostBlahoreceniTexty)) {
            $this->slavnostBlahoreceniTexties->add($slavnostBlahoreceniTexty);
            $slavnostBlahoreceniTexty->setKategorie($this);
        }

        return $this;
    }

    public function removeSlavnostBlahoreceniTexty(SlavnostBlahoreceniTexty $slavnostBlahoreceniTexty): static
    {
        if ($this->slavnostBlahoreceniTexties->removeElement($slavnostBlahoreceniTexty)) {
            // set the owning side to null (unless already changed)
            if ($slavnostBlahoreceniTexty->getKategorie() === $this) {
                $slavnostBlahoreceniTexty->setKategorie(null);
            }
        }

        return $this;
    }
}
