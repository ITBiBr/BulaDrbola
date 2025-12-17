<?php

namespace App\Entity;

use App\Repository\BodyMapyPribehRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BodyMapyPribehRepository::class)]
class BodyMapyPribeh
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $lat = null;

    private ?int $x = null;

    #[ORM\Column]
    private ?float $lng = null;

    private ?int $y = null;

    #[ORM\Column(length: 255)]
    private ?string $nazev = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $pribehMista = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $zajimavosti = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getNazev(): ?string
    {
        return $this->nazev;
    }

    public function setNazev(string $nazev): static
    {
        $this->nazev = $nazev;

        return $this;
    }

    public function getPribehMista(): ?string
    {
        return $this->pribehMista;
    }

    public function setPribehMista(?string $pribehMista): static
    {
        $this->pribehMista = $pribehMista;

        return $this;
    }

    public function getZajimavosti(): ?string
    {
        return $this->zajimavosti;
    }

    public function setZajimavosti(?string $zajimavosti): static
    {
        $this->zajimavosti = $zajimavosti;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getX(): ?int
    {
        return $this->x;
    }

    /**
     * @param int|null $x
     */
    public function setX(?int $x): static
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(?int $y): static
    {
        $this->y = $y;
        return $this;
    }

}
