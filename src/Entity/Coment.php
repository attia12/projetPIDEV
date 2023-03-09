<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ComentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentRepository::class)]
class Coment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   
   
     #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[a-z]+$/',
        message: 'Le contenu doit contenir uniquement des lettres minuscules.'
    )]
    
    private ?string $content = null;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[A-Z]/',
        message: 'Le titre doit commencer par une majuscule.'
    )]
    private ?string $author = null;


    
    /**
 * @ORM\ManyToOne(targetEntity=Aarticle::class)
 * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false)
 */
private ?Aarticle $article = null;

    public function getArticle(): ?Aarticle
    {
        return $this->article;
    }

    public function setArticle(?Aarticle $article): self
    {
        $this->article = $article;

        return $this;
    }


    

    #[ORM\Column(length: 255)]
    private ?string $id_article = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIdArticle(): ?string
    {
        return $this->id_article;
    }

    public function setIdArticle(string $id_article): self
    {
        $this->id_article = $id_article;

        return $this;
    }
}
