<?php

namespace App\Repository;

use App\Entity\CompanieCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanieCategories>
 *
 * @method CompanieCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanieCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanieCategories[]    findAll()
 * @method CompanieCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanieCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanieCategories::class);
    }

//    /**
//     * @return CompanieCategories[] Returns an array of CompanieCategories objects
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

//    public function findOneBySomeField($value): ?CompanieCategories
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
