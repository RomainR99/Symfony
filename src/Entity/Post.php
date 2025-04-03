<?php

namespace App\Entity;


use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $user = null; // Nom de l'utilisateur

    #[ORM\Column(length: 255)]
    private ?string $email = null; // Adresse email de l'utilisateur

    #[ORM\Column(length: 255)]
    private ?string $string = null; // Autre champ (chaîne de caractères)

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageFilename = null; // Nom du fichier image, nullable au cas où il n'y ait pas d'image

    #[ORM\Column(type: "string", length: 255)]
    private ?string $title = null; // Titre du post

    #[ORM\Column(type: "text")]
    private ?string $description = null; // Description du post

    // Getter et Setter pour l'ID
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter et Setter pour l'utilisateur
    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): static
    {
        $this->user = $user;
        return $this;
    }

    // Getter et Setter pour l'email
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    // Getter et Setter pour le champ string
    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(string $string): static
    {
        $this->string = $string;
        return $this;
    }

    // Getter et Setter pour l'image
    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): static
    {
        $this->imageFilename = $imageFilename;
        return $this;
    }

    // Getter et Setter pour le titre
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    // Getter et Setter pour la description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
}


