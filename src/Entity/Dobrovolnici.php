<?php

namespace App\Entity;

use App\Repository\DobrovolniciRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: DobrovolniciRepository::class)]
class Dobrovolnici
{
    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->Akce = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jmeno = null;

    #[ORM\Column(length: 255)]
    private ?string $prijmeni = null;

    #[NotBlank(message: 'E-mail je povinný.')]
    #[Email(message: 'Zadejte platný e-mail.')]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Regex(
        pattern: '/^[+]?[\(\)0-9. -]{9,}$/',
        message: 'Zadejte platné telefonní číslo.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $telefon = null;

    #[IsTrue(message: 'Souhlas s GDPR musí být udělen.')]
    #[ORM\Column]
    private ?bool $isSouhlasGdpr = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    /**
     * @var Collection<int, DobrovolniciAkceCiselnik>
     */
    #[ORM\ManyToMany(targetEntity: DobrovolniciAkceCiselnik::class, inversedBy: 'dobrovolnicis')]
    private Collection $Akce;

    #[ORM\Column]
    private ?int $vek = null;

    #[ORM\Column]
    private ?bool $isZkusenosti = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $vzkaz = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $zkusenosti = null;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection<int, DobrovolniciAkceCiselnik>
     */
    public function getAkce(): Collection
    {
        return $this->Akce;
    }

    public function addAkce(DobrovolniciAkceCiselnik $akce): static
    {
        if (!$this->Akce->contains($akce)) {
            $this->Akce->add($akce);
        }

        return $this;
    }

    public function removeAkce(DobrovolniciAkceCiselnik $akce): static
    {
        $this->Akce->removeElement($akce);

        return $this;
    }

    public function getVek(): ?int
    {
        return $this->vek;
    }

    public function setVek(int $vek): static
    {
        $this->vek = $vek;

        return $this;
    }

    public function isZkusenosti(): ?bool
    {
        return $this->isZkusenosti;
    }

    public function setIsZkusenosti(bool $isZkusenosti): static
    {
        $this->isZkusenosti = $isZkusenosti;

        return $this;
    }

    public function getVzkaz(): ?string
    {
        return $this->vzkaz;
    }

    public function setVzkaz(?string $vzkaz): static
    {
        $this->vzkaz = $vzkaz;

        return $this;
    }

    public function getZkusenosti(): ?string
    {
        return $this->zkusenosti;
    }

    public function setZkusenosti(?string $zkusenosti): static
    {
        $this->zkusenosti = $zkusenosti;

        return $this;
    }
}
