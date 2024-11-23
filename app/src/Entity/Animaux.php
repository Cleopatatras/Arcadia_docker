<?php

namespace App\Entity;

use App\Repository\AnimauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimauxRepository::class)]
class Animaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    private ?string $race = null;

    #[ORM\ManyToOne(inversedBy: 'animauxes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitats $habitat = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'animal')]
    private Collection $images;

    /**
     * @var Collection<int, CompteRendu>
     */
    #[ORM\OneToMany(targetEntity: CompteRendu::class, mappedBy: 'animal')]
    private Collection $compteRendus;

    #[ORM\Column]
    private int $views = 0;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnimal($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnimal() === $this) {
                $image->setAnimal(null);
            }
        }

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
            $compteRendu->setAnimal($this);
        }

        return $this;
    }

    public function removeCompteRendu(CompteRendu $compteRendu): static
    {
        if ($this->compteRendus->removeElement($compteRendu)) {
            // set the owning side to null (unless already changed)
            if ($compteRendu->getAnimal() === $this) {
                $compteRendu->setAnimal(null);
            }
        }

        return $this;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function incrementViews(): self
    {
        $this->views++;
        return $this;
    }

}