<?php

namespace App\Entity;

use App\Repository\StatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatisticsRepository::class)]
class Statistics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $hp_max = null;

    #[ORM\Column(nullable: true)]
    private ?float $hp�_min = null;

    #[ORM\Column(nullable: true)]
    private ?int $size = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    #[ORM\ManyToOne(inversedBy: 'statistics')]
    private ?Pokemon $pokemon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHpMax(): ?float
    {
        return $this->hp_max;
    }

    public function setHpMax(?float $hp_max): self
    {
        $this->hp_max = $hp_max;

        return $this;
    }

    public function getHp�Min(): ?float
    {
        return $this->hp�_min;
    }

    public function setHp�Min(?float $hp�_min): self
    {
        $this->hp�_min = $hp�_min;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }
}
