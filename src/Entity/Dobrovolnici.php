<?php

namespace App\Entity;

use App\Repository\DobrovolniciRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DobrovolniciRepository::class)]
class Dobrovolnici
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jmeno = null;

    #[ORM\Column(length: 255)]
    private ?string $prijmeni = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telefon = null;

    #[ORM\Column]
    private ?bool $isSouhlasGdpr = null;

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

    public function getPrijmeni(): ?string
    {
        return $this->prijmeni;
    }

    public function setPrijmeni(string $prijmeni): static
    {
        $this->prijmeni = $prijmeni;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefon(): ?string
    {
        return $this->telefon;
    }

    public function setTelefon(string $telefon): static
    {
        $this->telefon = $telefon;

        return $this;
    }

    public function isSouhlasGdpr(): ?bool
    {
        return $this->isSouhlasGdpr;
    }

    public function setIsSouhlasGdpr(bool $isSouhlasGdpr): static
    {
        $this->isSouhlasGdpr = $isSouhlasGdpr;

        return $this;
    }
}
