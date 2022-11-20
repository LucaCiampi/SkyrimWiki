<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Race::class)]
    private Collection $races_created;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: City::class)]
    private Collection $cities_made;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Province::class)]
    private Collection $provinces_made;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Follower::class)]
    private Collection $followers_made;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Skill::class)]
    private Collection $skills_made;

    public function __construct()
    {
        $this->races_created = new ArrayCollection();
        $this->cities_made = new ArrayCollection();
        $this->provinces_made = new ArrayCollection();
        $this->followers_made = new ArrayCollection();
        $this->skills_made = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Race>
     */
    public function getRacesCreated(): Collection
    {
        return $this->races_created;
    }

    public function addRacesCreated(Race $racesCreated): self
    {
        if (!$this->races_created->contains($racesCreated)) {
            $this->races_created->add($racesCreated);
            $racesCreated->setAuthor($this);
        }

        return $this;
    }

    public function removeRacesCreated(Race $racesCreated): self
    {
        if ($this->races_created->removeElement($racesCreated)) {
            // set the owning side to null (unless already changed)
            if ($racesCreated->getAuthor() === $this) {
                $racesCreated->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCitiesMade(): Collection
    {
        return $this->cities_made;
    }

    public function addCitiesMade(City $citiesMade): self
    {
        if (!$this->cities_made->contains($citiesMade)) {
            $this->cities_made->add($citiesMade);
            $citiesMade->setAuthor($this);
        }

        return $this;
    }

    public function removeCitiesMade(City $citiesMade): self
    {
        if ($this->cities_made->removeElement($citiesMade)) {
            // set the owning side to null (unless already changed)
            if ($citiesMade->getAuthor() === $this) {
                $citiesMade->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Province>
     */
    public function getProvincesMade(): Collection
    {
        return $this->provinces_made;
    }

    public function addProvincesMade(Province $provincesMade): self
    {
        if (!$this->provinces_made->contains($provincesMade)) {
            $this->provinces_made->add($provincesMade);
            $provincesMade->setAuthor($this);
        }

        return $this;
    }

    public function removeProvincesMade(Province $provincesMade): self
    {
        if ($this->provinces_made->removeElement($provincesMade)) {
            // set the owning side to null (unless already changed)
            if ($provincesMade->getAuthor() === $this) {
                $provincesMade->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Follower>
     */
    public function getFollowersMade(): Collection
    {
        return $this->followers_made;
    }

    public function addFollowersMade(Follower $followersMade): self
    {
        if (!$this->followers_made->contains($followersMade)) {
            $this->followers_made->add($followersMade);
            $followersMade->setAuthor($this);
        }

        return $this;
    }

    public function removeFollowersMade(Follower $followersMade): self
    {
        if ($this->followers_made->removeElement($followersMade)) {
            // set the owning side to null (unless already changed)
            if ($followersMade->getAuthor() === $this) {
                $followersMade->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkillsMade(): Collection
    {
        return $this->skills_made;
    }

    public function addSkillsMade(Skill $skillsMade): self
    {
        if (!$this->skills_made->contains($skillsMade)) {
            $this->skills_made->add($skillsMade);
            $skillsMade->setAuthor($this);
        }

        return $this;
    }

    public function removeSkillsMade(Skill $skillsMade): self
    {
        if ($this->skills_made->removeElement($skillsMade)) {
            // set the owning side to null (unless already changed)
            if ($skillsMade->getAuthor() === $this) {
                $skillsMade->setAuthor(null);
            }
        }

        return $this;
    }
}
