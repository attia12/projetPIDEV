<?php

namespace App\Entity;

use App\Repository\ReportsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportsRepository::class)]
class Reports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: 'text')]
    private ?string $message = null;

    /**
     * @ORM\ManyToOne(targetEntity=Aarticle::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_aarticle;

    /**
     * @ORM\ManyToOne(targetEntity=Uuser::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_uuser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getIdAarticle(): ?Aarticle
    {
        return $this->id_aarticle;
    }

    public function setIdAarticle(?Aarticle $id_aarticle): self
    {
        $this->id_aarticle = $id_aarticle;

        return $this;
    }

    public function getIdUuser(): ?Uuser
    {
        return $this->id_uuser;
    }

    public function setIdUuser(Uuser $id_uuser): self
    {
        $this->id_uuser = $id_uuser;

        return $this;
    }

}
