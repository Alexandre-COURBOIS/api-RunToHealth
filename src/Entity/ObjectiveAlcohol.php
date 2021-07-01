<?php

namespace App\Entity;

use App\Repository\ObjectiveAlcoholRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjectiveAlcoholRepository::class)
 */
class ObjectiveAlcohol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $drink;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=objectives::class, cascade={"remove"},orphanRemoval=true)
     */
    private $objective;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrink(): ?bool
    {
        return $this->drink;
    }

    public function setDrink(bool $drink): self
    {
        $this->drink = $drink;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getObjective(): ?objectives
    {
        return $this->objective;
    }

    public function setObjective(?objectives $objective): self
    {
        $this->objective = $objective;

        return $this;
    }
}
