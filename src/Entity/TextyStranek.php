<?php

namespace App\Entity;

use App\Repository\TextyStranekRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TextyStranekRepository::class)]
class TextyStranek
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $stranka = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    private ?string $identifikator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nadpis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStranka(): ?string
    {
        return $this->stranka;
    }

    public function setStranka(string $stranka): static
    {
        $this->stranka = $stranka;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
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

    public function getNadpis(): ?string
    {
        return $this->nadpis;
    }

    public function setNadpis(?string $nadpis): static
    {
        $this->nadpis = $nadpis;

        return $this;
    }
}
