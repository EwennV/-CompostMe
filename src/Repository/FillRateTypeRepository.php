<?php

namespace App\Repository;

use App\Entity\FillRateType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FillRateType>
 *
 * @method FillRateType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FillRateType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FillRateType[]    findAll()
 * @method FillRateType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FillRateTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FillRateType::class);
    }

//    /**
//     * @return FillRateType[] Returns an array of FillRateType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FillRateType
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
