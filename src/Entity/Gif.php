<?php

namespace App\Entity;

use App\Repository\GifRepository;
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
}
