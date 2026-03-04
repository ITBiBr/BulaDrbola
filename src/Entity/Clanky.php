<?php

namespace App\Entity;

use App\Repository\ClankyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: ClankyRepository::class)]
class Clanky
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[NotBlank(message: 'Content must not be blank.')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $Obsah = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Obrazek = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulek = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $IlustraceObsahu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Video = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ObsahPokracovani = null;

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

    public function setObrazek(?string $Obrazek): static
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

    public function getIlustraceObsahu(): ?string
    {
        return $this->IlustraceObsahu;
    }

    public function setIlustraceObsahu(?string $IlustraceObsahu): static
    {
        $this->IlustraceObsahu = $IlustraceObsahu;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->Video;
    }

    public function setVideo(?string $Video): static
    {
        $this->Video = $Video;

        return $this;
    }

    public function getObsahPokracovani(): ?string
    {
        return $this->ObsahPokracovani;
    }

    public function setObsahPokracovani(?string $ObsahPokracovani): static
    {
        $this->ObsahPokracovani = $ObsahPokracovani;

        return $this;
    }
}
