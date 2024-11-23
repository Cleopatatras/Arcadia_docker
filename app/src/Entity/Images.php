<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Animaux $animal = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Habitats $habitat = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Services $service = null;

    #[ORM\Column(length: 255)]
    private ?string $link_image = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

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

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getService(): ?Services
    {
        return $this->service;
    }

    public function setService(?Services $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getLinkImage(): ?string
    {
        return $this->link_image;
    }

    public function setLinkImage(string $link_image): static
    {
        $this->link_image = $link_image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
