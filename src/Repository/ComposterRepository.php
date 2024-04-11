<?php

namespace App\Repository;

use App\Entity\Composter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Composter>
 *
 * @method Composter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Composter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Composter[]    findAll()
 * @method Composter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Composter::class);
    }

    public function findByFilters($ownerTypeId, $accessTypeId, $fillRateId)
    {
        $qb = $this->createQueryBuilder('c');

        if (!empty($ownerTypeId)) {
            $ownerTypeIds = explode(',', $ownerTypeId);
            $qb->andWhere('c.ownerType IN (:ownerTypeIds)')
                ->setParameter('ownerTypeIds', $ownerTypeIds);
        }

        if (!empty($accessTypeId)) {
            $accessTypeIds = explode(',', $accessTypeId);
            $qb->andWhere('c.accessType IN (:accessTypeIds)')
                ->setParameter('accessTypeIds', $accessTypeIds);
        }

        if (!empty($fillRateId)) {
            $fillRateIds = explode(',', $fillRateId);
            $qb->andWhere('c.fillRate IN (:fillRateIds)')
                ->setParameter('fillRateIds', $fillRateIds);
        }

        return $qb->getQuery()->getResult();
    }



    //    /**
//     * @return Composter[] Returns an array of Composter objects
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

    //    public function findOneBySomeField($value): ?Composter
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
