<?php

namespace App\Entity;

use App\Repository\StitkyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StitkyRepository::class)]
class Stitky
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nazevStitku = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    /**
     * @var Collection<int, Akce>
     */
    #[ORM\ManyToMany(targetEntity: Akce::class, inversedBy: 'stitkies')]
    private Collection $Akce;

    public function __construct()
    {
        $this->Akce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazevStitku(): ?string
    {
        return $this->nazevStitku;
    }

    public function setNazevStitku(string $nazevStitku): static
    {
        $this->nazevStitku = $nazevStitku;

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

    /**
     * @return Collection<int, Akce>
     */
    public function getAkce(): Collection
    {
        return $this->Akce;
    }

    public function addAkce(Akce $akce): static
    {
        if (!$this->Akce->contains($akce)) {
            $this->Akce->add($akce);
        }

        return $this;
    }

    public function removeAkce(Akce $akce): static
    {
        $this->Akce->removeElement($akce);

        return $this;
    }
}
