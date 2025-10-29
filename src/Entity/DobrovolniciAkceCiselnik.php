<?php

namespace App\Entity;

use App\Repository\DobrovolniciAkceCiselnikRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DobrovolniciAkceCiselnikRepository::class)]
class DobrovolniciAkceCiselnik
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $polozkaCiselniku = null;

    /**
     * @var Collection<int, Dobrovolnici>
     */
    #[ORM\ManyToMany(targetEntity: Dobrovolnici::class, mappedBy: 'Akce')]
    private Collection $dobrovolnicis;

    #[ORM\Column]
    private ?bool $isActive = null;

    public function __construct()
    {
        $this->dobrovolnicis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPolozkaCiselniku(): ?string
    {
        return $this->polozkaCiselniku;
    }

    public function setPolozkaCiselniku(string $polozkaCiselniku): static
    {
        $this->polozkaCiselniku = $polozkaCiselniku;

        return $this;
    }

    /**
     * @return Collection<int, Dobrovolnici>
     */
    public function getDobrovolnicis(): Collection
    {
        return $this->dobrovolnicis;
    }

    public function addDobrovolnici(Dobrovolnici $dobrovolnici): static
    {
        if (!$this->dobrovolnicis->contains($dobrovolnici)) {
            $this->dobrovolnicis->add($dobrovolnici);
            $dobrovolnici->addAkce($this);
        }

        return $this;
    }

    public function removeDobrovolnici(Dobrovolnici $dobrovolnici): static
    {
        if ($this->dobrovolnicis->removeElement($dobrovolnici)) {
            $dobrovolnici->removeAkce($this);
        }

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }
}
