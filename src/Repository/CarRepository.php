<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\CarCategory;
use App\Entity\CarSearch;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAllVisibleQuery(CarSearch $search): Query
    {
        $query = $this->findQuery();
        if($search->getName()){
            $query =$query
                ->andwhere('p.name= :name')
                ->setParameter('name',strtolower($search->getName()) );
    
        }
        
    $carCateg=new CarCategory();
        if ($search->getNameCategory()){
            
            $query =$query
            ->andwhere('p.carCategory IN (:name)')
                ->setParameter('name', $this->registry->getRepository(CarCategory::class)->findBy(['nameCategory'=>$search->getNameCategory()]));
           
        }
    
        return $query->getQuery();
    
    }
    
        /**
         * @return array
         */
        public function findLatest():array
        {
            return $this->findQuery()
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
    
        }
        private function findQuery():QueryBuilder
        {
            return $this->createQueryBuilder('p')
                ->where('p.disponible=true');
    
        }


//    /**
//     * @return Car[] Returns an array of Car objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneById($value): ?Car
    {

        return $this->createQueryBuilder('v')
            ->andWhere('v.id = :val')
            ->setParameter('val', (int)$value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    
    public function findOneByNameCategoryId($value): ?Car
    {

        return $this->createQueryBuilder('v')
            ->andWhere('v.carCategory = :val')
            ->setParameter('val', (int)$value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
