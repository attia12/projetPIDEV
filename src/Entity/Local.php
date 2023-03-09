<?php

namespace App\Entity;

use App\Repository\LocalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: LocalRepository::class)]
class Local
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups("locals")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom  du block est requis")]
    #[Groups("locals")]
    private ?string $nomBlock = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom du la patient est requis")]
    #[Groups("locals")]
    #[Assert\Length(min: 2,minMessage: "veuillez avoir au minimum 2 caractere" )]
    private ?string $nomPatient = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom  du la medecin est requis")]
    #[Groups("locals")]
    private ?string $nomMedecin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le localisation est requis")]
    #[Groups("locals")]
    private ?string $localisation = null;

    #[ORM\OneToMany(mappedBy: 'locaux', targetEntity: Consultation::class)]
    private Collection $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBlock(): ?string
    {
        return $this->nomBlock;
    }

    public function setNomBlock(string $nomBlock): self
    {
        $this->nomBlock = $nomBlock;

        return $this;
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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setLocaux($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getLocaux() === $this) {
                $consultation->setLocaux(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->localisation;
    }
}
