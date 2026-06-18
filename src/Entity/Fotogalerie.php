<?php

namespace App\Entity;

use App\Repository\FotogalerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FotogalerieRepository::class)]
class Fotogalerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Foto>
     */
    #[ORM\OneToMany(targetEntity: Foto::class, mappedBy: 'fotogalerie')]
    private Collection $fotos;

    #[ORM\Column(length: 255)]
    private ?string $titulek = null;

    public function __construct()
    {
        $this->fotos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Foto>
     */
    public function getFotos(): Collection
    {
        return $this->fotos;
    }

    public function addFoto(Foto $foto): static
    {
        if (!$this->fotos->contains($foto)) {
            $this->fotos->add($foto);
            $foto->setFotogalerie($this);
        }

        return $this;
    }

    public function removeFoto(Foto $foto): static
    {
        if ($this->fotos->removeElement($foto)) {
            // set the owning side to null (unless already changed)
            if ($foto->getFotogalerie() === $this) {
                $foto->setFotogalerie(null);
            }
        }

        return $this;
    }

    public function getTitulek(): ?string
    {
        return $this->titulek;
    }

    public function setTitulek(string $titulek): static
    {
        $this->titulek = $titulek;

        return $this;
    }
}
