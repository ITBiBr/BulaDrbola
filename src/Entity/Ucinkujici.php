<?php

namespace App\Entity;

use App\Repository\UcinkujiciRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: UcinkujiciRepository::class)]
class Ucinkujici
{
    public function __construct()
    {
        $this->poradi = 0;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jmeno = null;

    #[ORM\Column(type: Types::TEXT)]
    #[NotBlank(message: 'Content must not be blank.')]
    private ?string $medailonek = null;

    #[ORM\Column(length: 255)]
    private ?string $obrazek = null;

    #[ORM\Column]
    private ?int $poradi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJmeno(): ?string
    {
        return $this->jmeno;
    }

    public function setJmeno(string $jmeno): static
    {
        $this->jmeno = $jmeno;

        return $this;
    }

    public function getMedailonek(): ?string
    {
        return $this->medailonek;
    }

    public function setMedailonek(string $medailonek): static
    {
        $this->medailonek = $medailonek;

        return $this;
    }

    public function getObrazek(): ?string
    {
        return $this->obrazek;
    }

    public function setObrazek(string $obrazek): static
    {
        $this->obrazek = $obrazek;

        return $this;
    }

    public function getPoradi(): ?int
    {
        return $this->poradi;
    }

    public function setPoradi(int $poradi): static
    {
        $this->poradi = $poradi;

        return $this;
    }
}
