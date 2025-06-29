<?php

namespace App\Entity;

use App\Repository\FishSpeciesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FishSpeciesRepository::class)]
class FishSpecies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $protection_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $protection_end = null;

    #[ORM\Column(nullable: true)]
    private ?int $daily_limit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $min_length = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProtectionStart(): ?\DateTime
    {
        return $this->protection_start;
    }

    public function setProtectionStart(\DateTime $protection_start): static
    {
        $this->protection_start = $protection_start;

        return $this;
    }

    public function getProtectionEnd(): ?\DateTime
    {
        return $this->protection_end;
    }

    public function setProtectionEnd(\DateTime $protection_end): static
    {
        $this->protection_end = $protection_end;

        return $this;
    }

    public function getDailyLimit(): ?int
    {
        return $this->daily_limit;
    }

    public function setDailyLimit(int $daily_limit): static
    {
        $this->daily_limit = $daily_limit;

        return $this;
    }

    public function getMinLength(): ?string
    {
        return $this->min_length;
    }

    public function setMinLength(string $min_length): static
    {
        $this->min_length = $min_length;

        return $this;
    }
}
