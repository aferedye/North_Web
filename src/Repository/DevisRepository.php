<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    // /**
    //  * @return Devis[] Returns an array of Devis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Devis
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function searchName($needle)
    {
        return $this->CreateQueryBuilder('m')
            ->where('m.nom LIKE :needle')
            ->setParameter('needle', "%".$needle."%")
            ->getQuery()
            ->getResult();

    }

    public function searchFirstname($needle)
    {
        return $this->CreateQueryBuilder('m')
            ->where('m.prenom LIKE :needle')
            ->setParameter('needle', "%".$needle."%")
            ->getQuery()
            ->getResult();

    }


    public function searchEmail($needle)
    {
        return $this->CreateQueryBuilder('m')
            ->where('m.email LIKE :needle')
            ->setParameter('needle', "%".$needle."%")
            ->getQuery()
            ->getResult();

    }

    public function searchId($needle)
    {
        return $this->CreateQueryBuilder('m')
            ->where('m.id LIKE :needle')
            ->setParameter('needle', "%".$needle."%")
            ->getQuery()
            ->getResult();

    }
}
