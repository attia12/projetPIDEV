<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank(message:"Le nom  du Medicament est requis")]
 
    #[ORM\Column(length: 255)]
    
    private ?string $nomMedicament = null;
    #[Assert\NotBlank(message:"Le description est requis")]
    #[Assert\Length(min: 6,minMessage: "veuillez avoir au minimum 6 caractere" )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 1,
        
    )]
    private ?int $quatite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Range(
        min: 'first day of January',
        max: 'first day of January next year',
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Category::class)]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMedicament(): ?string
    {
        return $this->nomMedicament;
    }

    public function setNomMedicament(string $nomMedicament): self
    {
        $this->nomMedicament = $nomMedicament;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuatite(): ?int
    {
        return $this->quatite;
    }

    public function setQuatite(int $quatite): self
    {
        $this->quatite = $quatite;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setCategories($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCategories() === $this) {
                $category->setCategories(null);
            }
        }

        return $this;
    }
}
