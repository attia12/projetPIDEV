<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("users")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom est requis")]
    #[Assert\Regex(pattern:"/^[A-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",message:"Le nom format n'est pas valide")]
    #[Groups("users")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le prenom est requis")]
    #[Assert\Regex(pattern:"/^[A-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",message:"Le prenom format n'est pas valide")]
    #[Groups("users")]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"L'email est requis")]
    #[Assert\Email(message:"L'email format est incorrecte")]
    #[Groups("users")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le mot de pass est requis")]
   #[Assert\Length(min:8,minMessage:"Le mot de pass doit ètre suprerieur a 8 caractére")]
   #[Groups("users")] 
   private ?string $mdp = null;
    #[Assert\NotBlank(message:"L'addresse est requis")]
    #[ORM\Column(length: 255)]
    #[Groups("users")]
    private ?string $adresse = null;
    #[Assert\NotBlank(message:"Le numero est requis")]
    #[ORM\Column]
    #[Groups("users")]
    private ?int $num = null;
    //[Assert\NotBlank(message:"Le type est requis")]
    #[ORM\Column(length: 255)]
    #[Groups("users")]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Groups("users")]
    private ?string $img = null;

    #[ORM\Column(nullable: true)]
    private ?int $etat = null;

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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(?int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
