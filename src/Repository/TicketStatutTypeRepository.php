<?php

namespace App\Repository;

use App\Entity\TicketStatutType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TicketStatutType>
 *
 * @method TicketStatutType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketStatutType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketStatutType[]    findAll()
 * @method TicketStatutType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketStatutTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketStatutType::class);
    }

//    /**
//     * @return TicketStatutType[] Returns an array of TicketStatutType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TicketStatutType
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
