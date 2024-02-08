<?php

namespace App\Repository;

use App\Entity\ComposterDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComposterDay>
 *
 * @method ComposterDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComposterDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComposterDay[]    findAll()
 * @method ComposterDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposterDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComposterDay::class);
    }

//    /**
//     * @return ComposterDay[] Returns an array of ComposterDay objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ComposterDay
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
