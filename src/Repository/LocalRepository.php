<?php

namespace App\Repository;

use App\Entity\Local;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Local>
 *
 * @method Local|null find($id, $lockMode = null, $lockVersion = null)
 * @method Local|null findOneBy(array $criteria, array $orderBy = null)
 * @method Local[]    findAll()
 * @method Local[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Local::class);
    }

    public function save(Local $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Local $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    
    public function SortByid(){
        return $this->createQueryBuilder('e')
            ->orderBy('e.id','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function SortBynomBlock()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nomBlock','ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    public function SortBynomPatient()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nomPatient','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function SortBynomMedecin()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nomMedecin','ASC')
            ->getQuery()
            ->getResult()
            ;
    }







    public function findByid( $id)
    {
        return $this-> createQueryBuilder('e')
            ->andWhere('e.id LIKE :id')
            ->setParameter('id','%' .$id. '%')
            ->getQuery()
            ->execute();
    }
    public function findBynomBlock( $nomBlock)
    {
        return $this-> createQueryBuilder('e')
            ->andWhere('e.nomBlock LIKE :nomBlock')
            ->setParameter('nomBlock','%' .$nomBlock. '%')
            ->getQuery()
            ->execute();
    }
    public function findBynomPatient( $nomPatient)
    {
        return $this-> createQueryBuilder('e')
            ->andWhere('e.nomPatient LIKE :nomPatient')
            ->setParameter('nomPatient','%' .$nomPatient. '%')
            ->getQuery()
            ->execute();
    }
    public function findBynomMedecin( $nomMedecin)
    {
        return $this-> createQueryBuilder('e')
            ->andWhere('e.nomMedecin LIKE :nomMedecin')
            ->setParameter('nomMedecin','%' .$nomMedecin. '%')
            ->getQuery()
            ->execute();
    }
//    /**
//     * @return Local[] Returns an array of Local objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Local
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
