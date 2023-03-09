<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

     /**
     * @ORM\Column(type="int")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}",
     * )
     */
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    private ?Aarticle $article_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getArticleId(): ?Aarticle
    {
        return $this->article_id;
    }

    public function setArticleId(?Aarticle $article_id): self
    {
        $this->article_id = $article_id;

        return $this;
    }

     public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

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
