<?php

namespace App\Entity;

use App\Repository\SlavnostBlahoreceniTextyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SlavnostBlahoreceniTextyRepository::class)]
class SlavnostBlahoreceniTexty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulek = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Text = null;

    #[ORM\ManyToOne(inversedBy: 'slavnostBlahoreceniTexties')]
    private ?SlavnostBlahoreceniKategorie $Kategorie = null;

    #[ORM\Column(nullable: true)]
    private ?int $priorita = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulek(): ?string
    {
        return $this->Titulek;
    }

    public function setTitulek(string $Titulek): static
    {
        $this->Titulek = $Titulek;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): static
    {
        $this->Text = $Text;

        return $this;
    }

    public function getKategorie(): ?SlavnostBlahoreceniKategorie
    {
        return $this->Kategorie;
    }

    public function setKategorie(?SlavnostBlahoreceniKategorie $Kategorie): static
    {
        $this->Kategorie = $Kategorie;

        return $this;
    }

    public function getPriorita(): ?int
    {
        return $this->priorita;
    }

    public function setPriorita(?int $priorita): static
    {
        $this->priorita = $priorita;

        return $this;
    }
}
