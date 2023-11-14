<?php

namespace App\Repository;

use App\Entity\CompaniesProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompaniesProfile>
 *
 * @method CompaniesProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompaniesProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompaniesProfile[]    findAll()
 * @method CompaniesProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompaniesProfile::class);
    }

//    /**
//     * @return CompaniesProfile[] Returns an array of CompaniesProfile objects
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

//    public function findOneBySomeField($value): ?CompaniesProfile
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
