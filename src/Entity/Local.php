<?php

namespace App\Entity;

use App\Repository\LocalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: LocalRepository::class)]
class Local
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank(message:"Le nom  du block est requis")]
    private ?string $nomBlock = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Le nom du la patient est requis")]
    #[Assert\Length(min: 2,minMessage: "veuillez avoir au minimum 2 caractere" )]
    private ?string $nomPatient = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Le nom  du la medecin est requis")]
    private ?string $nomMedecin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le localisation est requis")]
    private ?string $localisation = null;

    #[ORM\ManyToOne(inversedBy: 'locals')]
    private ?Consultation $locales = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBlock(): ?string
    {
        return $this->nomBlock;
    }

    public function setNomBlock(?string $nomBlock): self
    {
        $this->nomBlock = $nomBlock;

        return $this;
    }

    public function getNomPatient(): ?string
    {
        return $this->nomPatient;
    }

    public function setNomPatient(?string $nomPatient): self
    {
        $this->nomPatient = $nomPatient;

        return $this;
    }

    public function getNomMedecin(): ?string
    {
        return $this->nomMedecin;
    }

    public function setNomMedecin(?string $nomMedecin): self
    {
        $this->nomMedecin = $nomMedecin;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getLocales(): ?Consultation
    {
        return $this->locales;
    }

    public function setLocales(?Consultation $locales): self
    {
        $this->locales = $locales;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nomBlock. " " .$this->nomPatient. " " .$this->nomMedecin." ".$this->localisation;
    }
}
