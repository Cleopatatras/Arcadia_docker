<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: "horaires")]
class Horaires
{
    #[ODM\Id]
    private ?string $id = null;

    #[ODM\Field(type: "string")]
    private ?string $jour = null;

    #[ODM\Field(type: "string")]
    private ?string $ouverture = null;

    #[ODM\Field(type: "string")]
    private ?string $fermeture = null;

    #[ODM\Field(type: "bool")]
    private bool $ferme = false;

    // Getters et Setters
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;
        return $this;
    }

    public function getOuverture(): ?string
    {
        return $this->ouverture;
    }

    public function setOuverture(string $ouverture): self
    {
        $this->ouverture = $ouverture;
        return $this;
    }

    public function getFermeture(): ?string
    {
        return $this->fermeture;
    }

    public function setFermeture(string $fermeture): self
    {
        $this->fermeture = $fermeture;
        return $this;
    }

    public function isFerme(): bool
    {
        return $this->ferme;
    }

    public function setFerme(bool $ferme): self
    {
        $this->ferme = $ferme;
        return $this;
    }
}
