<?php

namespace App\Repository;

use App\Entity\Advertisements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Advertisements>
 *
 * @method Advertisements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisements[]    findAll()
 * @method Advertisements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisements::class);
    }


    public function get_job_byNameAndCategory($key){
        $query = $this->createQueryBuilder("c")
            ->andWhere("c.name_job LIKE :key")
            ->setParameter('key',"%" . $key ."%")
            ->orderBy('c.public_date', 'DESC')
            ->getQuery();

        return $query->getResult();
    }
//    /**
//     * @return Advertisements[] Returns an array of Advertisements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Advertisements
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
