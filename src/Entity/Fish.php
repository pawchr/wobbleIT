<?php

namespace App\Entity;

use App\Repository\FishRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishRepository::class)]
class Fish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Fishing::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fishing $fishing = null;

    #[ORM\Column]
    private ?int $species_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $length = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFishing(): ?Fishing
    {
        return $this->fishing;
    }

    public function setFishing(Fishing $fishing): static
    {
        $this->fishing = $fishing;
        return $this;
    }

    public function getSpeciesId(): ?int
    {
        return $this->species_id;
    }

    public function setSpeciesId(int $species_id): static
    {
        $this->species_id = $species_id;
        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(string $length): static
    {
        $this->length = $length;
        return $this;
    }
}
