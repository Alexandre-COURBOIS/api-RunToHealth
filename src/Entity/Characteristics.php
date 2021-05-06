<?php

namespace App\Entity;

use App\Repository\CharacteristicsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacteristicsRepository::class)
 *
 * @ORM\HasLifecycleCallbacks
 */
class Characteristics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\OneToMany(targetEntity=weight::class, mappedBy="characteristics")
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $smoker;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, mappedBy="characteristics", cascade={"persist", "remove"})
     */
    private $users;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function __construct()
    {
        $this->weight = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getSmoker(): ?bool
    {
        return $this->smoker;
    }

    public function setSmoker(bool $smoker): self
    {
        $this->smoker = $smoker;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|weight[]
     */
    public function getWeight(): Collection
    {
        return $this->weight;
    }

    public function addWeight(weight $weight): self
    {
        if (!$this->weight->contains($weight)) {
            $this->weight[] = $weight;
            $weight->setCharacteristics($this);
        }

        return $this;
    }

    public function removeWeight(weight $weight): self
    {
        if ($this->weight->removeElement($weight)) {
            // set the owning side to null (unless already changed)
            if ($weight->getCharacteristics() === $this) {
                $weight->setCharacteristics(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        // unset the owning side of the relation if necessary
        if ($users === null && $this->users !== null) {
            $this->users->setCharacteristics(null);
        }

        // set the owning side of the relation if necessary
        if ($users !== null && $users->getCharacteristics() !== $this) {
            $users->setCharacteristics($this);
        }

        $this->users = $users;

        return $this;
    }
}
