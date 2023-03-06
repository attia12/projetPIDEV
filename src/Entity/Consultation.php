<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups("consultations")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom du la patient est requis")]
    #[Groups("consultations")]
    #[Assert\Length(min: 2,minMessage: "veuillez avoir au minimum 2 caractere" )]
    private ?string $nomPatient = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom  du la medecin est requis")]
    #[Groups("consultations")]
    #[Assert\Regex("/^[a-zA-Z]/")]
    private ?string $nomMedecin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups("consultations")]
    #[Assert\NotBlank(message:"time est requis")]
    private ?\DateTimeInterface $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("consultations")]
    #[Assert\NotBlank(message:"date est requis")]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?Local $locaux = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPatient(): ?string
    {
        return $this->nomPatient;
    }

    public function setNomPatient(string $nomPatient): self
    {
        $this->nomPatient = $nomPatient;

        return $this;
    }

    public function getNomMedecin(): ?string
    {
        return $this->nomMedecin;
    }

    public function setNomMedecin(string $nomMedecin): self
    {
        $this->nomMedecin = $nomMedecin;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

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

    public function getLocaux(): ?Local
    {
        return $this->locaux;
    }

    public function setLocaux(?Local $locaux): self
    {
        $this->locaux = $locaux;

        return $this;
    }
    
}
