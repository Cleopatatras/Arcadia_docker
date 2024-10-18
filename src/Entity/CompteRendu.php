<?php

namespace App\Entity;

use App\Repository\CompteRenduRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRenduRepository::class)]
class CompteRendu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'compteRendus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animaux $animal = null;

    #[ORM\ManyToOne(inversedBy: 'compteRendus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $etat_animal = null;

    #[ORM\ManyToOne(inversedBy: 'compteRendus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nourriture $nourriture = null;

    #[ORM\Column]
    private ?float $grammage = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animaux
    {
        return $this->animal;
    }

    public function setAnimal(?Animaux $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEtatAnimal(): ?string
    {
        return $this->etat_animal;
    }

    public function setEtatAnimal(string $etat_animal): static
    {
        $this->etat_animal = $etat_animal;

        return $this;
    }

    public function getNourriture(): ?Nourriture
    {
        return $this->nourriture;
    }

    public function setNourriture(?Nourriture $nourriture): static
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    public function getGrammage(): ?float
    {
        return $this->grammage;
    }

    public function setGrammage(float $grammage): static
    {
        $this->grammage = $grammage;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }
}
