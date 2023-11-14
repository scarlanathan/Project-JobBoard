<?php

namespace App\Repository;

use App\Entity\JobCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobCategories>
 *
 * @method JobCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobCategories[]    findAll()
 * @method JobCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobCategories::class);
    }

    public function findJobByKey($key){
        return $this->createQueryBuilder('j')
            ->andWhere('j.name LIKE :key')
            ->setParameter('key','%' . $key . "%")
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return JobCategories[] Returns an array of JobCategories objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobCategories
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
