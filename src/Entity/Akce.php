<?php

namespace App\Entity;

use App\Repository\AkceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: AkceRepository::class)]
class Akce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[NotBlank(message: 'Perex must not be blank.')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $Perex = null;

    #[NotBlank(message: 'Content must not be blank.')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $Obsah = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $Datum = null;

    #[ORM\Column]
    private ?\DateTime $DatumZobrazeniOd = null;

    #[ORM\Column(length: 255)]
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

    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    private ?float $lng = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MistoKonani = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $DatumDo = null;

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

    public function getDatumZobrazeniOd(): ?\DateTime
    {
        return $this->DatumZobrazeniOd;
    }

    public function setDatumZobrazeniOd(\DateTime $DatumZobrazeniOd): static
    {
        $this->DatumZobrazeniOd = $DatumZobrazeniOd;

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

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getMistoKonani(): ?string
    {
        return $this->MistoKonani;
    }

    public function setMistoKonani(?string $MistoKonani): static
    {
        $this->MistoKonani = $MistoKonani;

        return $this;
    }

    public function getDatumDo(): ?\DateTime
    {
        return $this->DatumDo;
    }

    public function setDatumDo(?\DateTime $DatumDo): static
    {
        $this->DatumDo = $DatumDo;

        return $this;
    }

    #[Callback]
    public function validateDatumDo(ExecutionContextInterface $context): void
    {
        if ($this->Datum && $this->DatumDo && $this->DatumDo <= $this->Datum) {
            $context->buildViolation('akce.date_to_must_be_greater')
                ->setTranslationDomain('validators')
                ->atPath('DatumDo')
                ->addViolation();
        }
    }
}
