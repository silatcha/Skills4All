<?php

namespace App\Repository;

use App\Entity\CarCategorySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarCategorySearch>
 *
 * @method CarCategorySearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarCategorySearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarCategorySearch[]    findAll()
 * @method CarCategorySearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarCategorySearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarCategorySearch::class);
    }

    public function save(CarCategorySearch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CarCategorySearch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CarCategorySearch[] Returns an array of CarCategorySearch objects
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

//    public function findOneBySomeField($value): ?CarCategorySearch
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
