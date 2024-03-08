<?php

namespace App\Repository;

use App\Entity\OpeningDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OpeningDate>
 *
 * @method OpeningDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpeningDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpeningDate[]    findAll()
 * @method OpeningDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpeningDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpeningDate::class);
    }

//    /**
//     * @return OpeningDate[] Returns an array of OpeningDate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OpeningDate
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
