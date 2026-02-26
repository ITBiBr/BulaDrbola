<?php

namespace App\Entity;

use App\Repository\NastaveniWebuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NastaveniWebuRepository::class)]
class NastaveniWebu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identifikator = null;

    #[ORM\Column(length: 255)]
    private ?string $nastaveni = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifikator(): ?string
    {
        return $this->identifikator;
    }

    public function setIdentifikator(string $identifikator): static
    {
        $this->identifikator = $identifikator;

        return $this;
    }

    public function getNastaveni(): ?string
    {
        return $this->nastaveni;
    }

    public function setNastaveni(string $nastaveni): static
    {
        $this->nastaveni = $nastaveni;

        return $this;
    }
}
