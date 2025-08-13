<?php

namespace App\Entity;

use App\Repository\AktualityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AktualityRepository::class)]
class Aktuality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Perex = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Obsah = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $Datum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerex(): ?string
    {
        return $this->Perex;
    }

    public function setPerex(?string $Perex): static
    {
        $this->Perex = $Perex;

        return $this;
    }

    public function getObsah(): ?string
    {
        return $this->Obsah;
    }

    public function setObsah(string $Obsah): static
    {
        $this->Obsah = $Obsah;

        return $this;
    }

    public function getDatum(): ?\DateTime
    {
        return $this->Datum;
    }

    public function setDatum(?\DateTime $Datum): static
    {
        $this->Datum = $Datum;

        return $this;
    }
}
