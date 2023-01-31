<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\ManyToMany(targetEntity: Gif::class, inversedBy: 'voters')]
    #[ORM\JoinTable(name: 'vote')]
    private Collection $vote;

    #[ORM\ManyToMany(targetEntity: Gif::class, inversedBy: 'collectors')]
    #[ORM\JoinTable(name: 'collection')]
    private Collection $collection;

    public function __construct()
    {
        $this->vote = new ArrayCollection();
        $this->collection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Gif>
     */
    public function getVotes(): Collection
    {
        return $this->vote;
    }

    public function addToVotes(Gif $vote): self
    {
        if (!$this->vote->contains($vote)) {
            $this->vote->add($vote);
        }

        return $this;
    }

    public function removeFromVotes(Gif $vote): self
    {
        $this->vote->removeElement($vote);

        return $this;
    }

    /**
     * @return Collection<int, Gif>
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function addToCollection(Gif $collection): self
    {
        if (!$this->collection->contains($collection)) {
            $this->collection->add($collection);
        }

        return $this;
    }

    public function removeFromCollection(Gif $collection): self
    {
        $this->collection->removeElement($collection);

        return $this;
    }
}
