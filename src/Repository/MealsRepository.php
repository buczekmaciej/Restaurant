<?php

namespace App\Repository;

use App\Entity\Meals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Meals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meals[]    findAll()
 * @method Meals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meals::class);
    }

    public function getSortedMeals()
    {
        $output = [];

        $types = $this->createQueryBuilder('m')
            ->select("DISTINCT t.Name")
            ->leftJoin('m.Type', 't')
            ->orderBy('t.Name', 'ASC')
            ->getQuery()
            ->getResult();

        $elems = $this->createQueryBuilder('m')
            ->getQuery()
            ->getResult();

        foreach ($types as $type) {
            foreach ($elems as $e) {
                if ($e->getType()->getName() == $type['Name']) $output[$type['Name']][] = $e;
            }
        }

        return $output;
    }

    public function getOrderMeals()
    {
        return $this->createQueryBuilder('m')
            ->select('m.id, m.Name, m.Price')
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return Meals[] Returns an array of Meals objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meals
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
