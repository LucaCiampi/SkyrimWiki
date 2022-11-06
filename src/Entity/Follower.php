<?php

namespace App\Entity;

use App\Repository\FollowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowerRepository::class)]
class Follower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'followers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Race $Race = null;

    #[ORM\ManyToOne(inversedBy: 'followers')]
    private ?City $livingIn = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->Race;
    }

    public function setRace(?Race $Race): self
    {
        $this->Race = $Race;

        return $this;
    }

    public function getLivingIn(): ?City
    {
        return $this->livingIn;
    }

    public function setLivingIn(?City $livingIn): self
    {
        $this->livingIn = $livingIn;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }
}
