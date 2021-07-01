<?php

namespace App\Entity;

use App\Repository\ObjectivesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjectivesRepository::class)
 */
class Objectives
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $begin_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $end_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sucess;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="objectives")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBeginAt(): ?string
    {
        return $this->begin_at;
    }

    public function setBeginAt(string $begin_at): self
    {
        $this->begin_at = $begin_at;

        return $this;
    }

    public function getEndAt(): ?string
    {
        return $this->end_at;
    }

    public function setEndAt(string $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getSucess(): ?bool
    {
        return $this->sucess;
    }

    public function setSucess(bool $sucess): self
    {
        $this->sucess = $sucess;

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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
