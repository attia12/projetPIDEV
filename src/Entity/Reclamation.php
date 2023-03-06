<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("reclamation")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 4,minMessage: "veuillez avoir au minimum 4 caractere" )]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'Your name cannot contain a number',)]
    #[Groups("reclamation")]

    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 4,minMessage: "veuillez avoir au minimum 4 caractere" )]


    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'Your prenom cannot contain a number',
    )]
    #[Groups("reclamation")]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Groups("reclamation")]

    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    #[Groups("reclamation")]
    private ?int $status = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Regex("/^[a-zA-Z]/")]
    #[Groups("reclamation")]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'reclamation', targetEntity: Response::class ,cascade: ['persist','remove'] )]
    private Collection $response;

    public function __construct()
    {
        $this->response = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Response>
     */
    public function getResponse(): Collection
    {
        return $this->response;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->response->contains($response)) {
            $this->response->add($response);
            $response->setReclamation($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->response->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getReclamation() === $this) {
                $response->setReclamation(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom. " " .$this->prenom. " " .$this->email." ".$this->status." ".$this->description;
    }
}
