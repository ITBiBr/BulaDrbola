<?php

namespace App\Entity;

use App\Repository\MaterialyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialyRepository::class)]
class Materialy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, MaterialyKategorie>
     */
    #[ORM\ManyToMany(targetEntity: MaterialyKategorie::class, inversedBy: 'materialies')]
    private Collection $Kategorie;

    #[ORM\Column(length: 255)]
    private ?string $Popis = null;

    #[ORM\Column(length: 255)]
    private ?string $Soubor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NazevSouboru = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $TypSouboru = null;

    #[ORM\Column]
    private ?\DateTime $DatumVlozeni = null;

    #[ORM\Column(length: 255)]
    private ?string $Nazev = null;

    public function __construct()
    {
        $this->Kategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, MaterialyKategorie>
     */
    public function getKategorie(): Collection
    {
        return $this->Kategorie;
    }

    public function addKategorie(MaterialyKategorie $kategorie): static
    {
        if (!$this->Kategorie->contains($kategorie)) {
            $this->Kategorie->add($kategorie);
        }

        return $this;
    }

    public function removeKategorie(MaterialyKategorie $kategorie): static
    {
        $this->Kategorie->removeElement($kategorie);

        return $this;
    }

    public function getPopis(): ?string
    {
        return $this->Popis;
    }

    public function setPopis(string $Popis): static
    {
        $this->Popis = $Popis;

        return $this;
    }

    public function getSoubor(): ?string
    {
        return $this->Soubor;
    }

    public function setSoubor(string $Soubor): static
    {
        $this->Soubor = $Soubor;

        return $this;
    }

    public function getNazevSouboru(): ?string
    {
        return $this->NazevSouboru;
    }

    public function setNazevSouboru(?string $NazevSouboru): static
    {
        $this->NazevSouboru = $NazevSouboru;

        return $this;
    }

    public function getTypSouboru(): ?string
    {
        return $this->TypSouboru;
    }

    public function setTypSouboru(?string $TypSouboru): static
    {
        $this->TypSouboru = $TypSouboru;

        return $this;
    }

    public function getDatumVlozeni(): ?\DateTime
    {
        return $this->DatumVlozeni;
    }

    public function setDatumVlozeni(\DateTime $DatumVlozeni): static
    {
        $this->DatumVlozeni = $DatumVlozeni;

        return $this;
    }

    public function getNazev(): ?string
    {
        return $this->Nazev;
    }

    public function setNazev(string $Nazev): static
    {
        $this->Nazev = $Nazev;

        return $this;
    }
}
