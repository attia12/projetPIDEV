<?php

namespace App\Entity;

use App\Repository\AarticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Seria1izer\Annotation\Groups;
use Symfony\Component\SeriaIizer\NormaIizer\NormaIizerInterface;
use Symfony\Component\Seria1izer\Seria1izerInterface;
use App\Entity\Reports;
#[ORM\Entity(repositoryClass: AarticleRepository::class)]
class Aarticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("aarticles")]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[A-Z]/',
        message: 'Le titre doit commencer par une majuscule.'
    )]
    #[ORM\Column(length: 255)]
    #[Groups("aarticles")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("aarticles")]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 500,
        maxMessage: 'The description must be no longer than {{ limit }} characters.'
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups("aarticles")]
    private ?string $published = null;

    #[ORM\Column(length: 255)]
    #[Groups("aarticles")]
    private ?string $image = null;




  /**
 * @ORM\OneToMany(targetEntity="App\Entity\Reports", mappedBy="aarticle")
 */
private $reports;

/**
 * @var int
 */
private int $reportsCount = 0;
    
    
  
    public function getReportsCount(): int
    {
        return $this->reportsCount;
    }

    public function setReportsCount(int $reportsCount): self
    {
        $this->reportsCount = $reportsCount;

        return $this;
    }

    public function addReports(Reports $reports): self
    {
        if (!$this->reports->contains($reports)) {
            $this->reports[] = $reports;
            $reports->setArticle($this);
            $this->reportsCount++;
        }

        return $this;
    }

    public function removeReports(Reports $reports): self
    {
        if ($this->reports->removeElement($reports)) {
            // set the owning side to null (unless already changed)
            if ($reports->getAarticle() === $this) {
                $reports->setAarticle(null);
                $this->reportsCount--;
            }
        }

        return $this;
    }


    /**
     * @return Collection|reports[]
     */
    public function getreports(): Collection {
        return $this->reports ?? new ArrayCollection();
    }



/**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $dislikes = 0;
    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }





    





/**
     * @ORM\OneToMany(targetEntity=Coment::class, mappedBy="article")
     */
    private $comments;

    #[ORM\OneToMany(mappedBy: 'article_id', targetEntity: Rating::class)]
    private Collection $ratings;

    #[ORM\OneToMany(mappedBy: 'id_article', targetEntity: PostLike::class)]
   

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->reports = new ArrayCollection();
        
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Coment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Coment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }



    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setIdAarticle(Aarticle $aarticle): self
{
    $this->id_aarticle = $aarticle;

    return $this;
}
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPublished(): ?string
    {
        return $this->published;
    }

    public function setPublished(string $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }




  


    
    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;



        $totalRating = 0;
    $numberOfRatings = 0;
    foreach ($this->ratings as $rating) {
        $totalRating += $rating->getValue();
        $numberOfRatings++;
    }
    if ($numberOfRatings === 0) {
        return null;
    }
    return $totalRating / $numberOfRatings;




    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setArticleId($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getArticleId() === $this) {
                $rating->setArticleId(null);
            }
        }

        return $this;
        
    }

    public function getAverageRating(): ?float
{
    $totalRating = 0;
    $numberOfRatings = 0;
    foreach ($this->ratings as $rating) {
        $totalRating += $rating->getValue();
        $numberOfRatings++;
    }
    if ($numberOfRatings === 0) {
        return null;
    }
    return $totalRating / $numberOfRatings;
}
}
