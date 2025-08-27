<?php

namespace App\Entity;

use App\Repository\ClankyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClankyRepository::class)]
class Clanky
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Obsah = null;

    #[ORM\Column(length: 255)]
    private ?string $Obrazek = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulek = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getObrazek(): ?string
    {
        return $this->Obrazek;
    }

    public function setObrazek(string $Obrazek): static
    {
        $this->Obrazek = $Obrazek;

        return $this;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
