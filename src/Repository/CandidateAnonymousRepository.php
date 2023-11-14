<?php

namespace App\Repository;

use App\Entity\CandidateAnonymous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidateAnonymous>
 *
 * @method CandidateAnonymous|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidateAnonymous|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidateAnonymous[]    findAll()
 * @method CandidateAnonymous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateAnonymousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidateAnonymous::class);
    }

//    /**
//     * @return CandidateAnonymous[] Returns an array of CandidateAnonymous objects
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

//    public function findOneBySomeField($value): ?CandidateAnonymous
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
