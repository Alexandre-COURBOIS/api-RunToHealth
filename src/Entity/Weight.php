<?php

namespace App\Entity;

use App\Repository\WeightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WeightRepository::class)
 *
 * @ORM\HasLifecycleCallbacks
 */
class Weight
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner votre poids.",
     *     groups={"Register"}
     *     )
     *
     * @Assert\Length(
     *     min="3",
     *     max="3",
     *     minMessage="Merci de renseigner un poids",
     *     groups={"Register"}
     *     )
     *
     * @Assert\Regex(
     *     pattern="/^(?:[1-9]\d|300)$/",
     *     message="Merci de renseigner un poids valide.",
     *     groups={"Register"},
     * )
     *
     */
    private $weight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Characteristics::class, mappedBy="weight")
     */
    private $characteristics;

    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
    }

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

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

    /**
     * @return Collection|Characteristics[]
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristics $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics[] = $characteristic;
            $characteristic->setWeight($this);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristics $characteristic): self
    {
        if ($this->characteristics->removeElement($characteristic)) {
            // set the owning side to null (unless already changed)
            if ($characteristic->getWeight() === $this) {
                $characteristic->setWeight(null);
            }
        }

        return $this;
    }

}
