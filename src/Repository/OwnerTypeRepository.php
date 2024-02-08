<?php

namespace App\Repository;

use App\Entity\OwnerType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OwnerType>
 *
 * @method OwnerType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnerType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnerType[]    findAll()
 * @method OwnerType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnerType::class);
    }

//    /**
//     * @return OwnerType[] Returns an array of OwnerType objects
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

//    public function findOneBySomeField($value): ?OwnerType
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
