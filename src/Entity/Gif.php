<?php

namespace App\Entity;

use App\Repository\GifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GifRepository::class)]
class Gif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbOfVotes = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'vote')]
    private Collection $voters;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'collection')]
    private Collection $collectors;

    public function __construct()
    {
        $this->voters = new ArrayCollection();
        $this->collectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getNbOfVotes(): ?int
    {
        return $this->nbOfVotes;
    }

    public function setNbOfVotes(?int $nbOfVotes): self
    {
        $this->nbOfVotes = $nbOfVotes;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getVoters(): Collection
    {
        return $this->voters;
    }

    public function addVoter(User $voter): self
    {
        if (!$this->voters->contains($voter)) {
            $this->voters->add($voter);
            $voter->addToVotes($this);
        }

        return $this;
    }

    public function removeVoter(User $voter): self
    {
        if ($this->voters->removeElement($voter)) {
            $voter->removeFromVotes($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getCollectors(): Collection
    {
        return $this->collectors;
    }

    public function addCollector(User $collector): self
    {
        if (!$this->collectors->contains($collector)) {
            $this->collectors->add($collector);
            $collector->addToCollection($this);
        }

        return $this;
    }

    public function removeCollector(User $collector): self
    {
        if ($this->collectors->removeElement($collector)) {
            $collector->removeFromCollection($this);
        }

        return $this;
    }
}
