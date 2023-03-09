<?php

namespace App\Repository;

use App\Entity\Aarticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aarticle>
 *
 * @method Aarticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aarticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aarticle[]    findAll()
 * @method Aarticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AarticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aarticle::class);
    }

    public function save(Aarticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Aarticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByTitle($title)
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.title LIKE :title')
        ->setParameter('title', '%'.$title.'%')
        ->orderBy('a.title', 'ASC')
        ->getQuery()
        ->getResult();
}

public function getAverageRating(): ?float
{
    $ratings = $this->getRatings();

    if ($ratings->isEmpty()) {
        return null;
    }

    $sum = 0;
    foreach ($ratings as $rating) {
        $sum += $rating->getNote();
    }

    return $sum / $ratings->count();
}



//    /**
//     * @return Aarticle[] Returns an array of Aarticle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Aarticle
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
