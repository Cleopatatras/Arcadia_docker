<?php

namespace App\Entity;

use App\Repository\NourritureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NourritureRepository::class)]
class Nourriture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @var Collection<int, CompteRendu>
     */
    #[ORM\OneToMany(targetEntity: CompteRendu::class, mappedBy: 'nourriture')]
    private Collection $compteRendus;

    public function __construct()
    {
        $this->compteRendus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, CompteRendu>
     */
    public function getCompteRendus(): Collection
    {
        return $this->compteRendus;
    }

    public function addCompteRendu(CompteRendu $compteRendu): static
    {
        if (!$this->compteRendus->contains($compteRendu)) {
            $this->compteRendus->add($compteRendu);
            $compteRendu->setNourriture($this);
        }

        return $this;
    }

    public function removeCompteRendu(CompteRendu $compteRendu): static
    {
        if ($this->compteRendus->removeElement($compteRendu)) {
            // set the owning side to null (unless already changed)
            if ($compteRendu->getNourriture() === $this) {
                $compteRendu->setNourriture(null);
            }
        }

        return $this;
    }
}
