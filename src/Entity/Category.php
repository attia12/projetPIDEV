<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom  du Medicament est requis")]
    #[Assert\Length(min: 2,minMessage: "veuillez avoir au minimum 2 caractere" )]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?Medicament $categories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategories(): ?Medicament
    {
        return $this->categories;
    }

    public function setCategories(?Medicament $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom;
    }
}
