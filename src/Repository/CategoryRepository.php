<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function saveCategoryStatus($status, $id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "UPDATE category SET status = '$status' WHERE id ='$id'";
        $conn->executeQuery($sql);
    }

    public function updateAllStatusCategory($status)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "UPDATE category SET status = '$status'";
        $conn->executeQuery($sql);
    }
    public function getCategoryId($id)
    {
         return $this->getEntityManager()->getRepository(Category::class)->findBy(['id' => $id]);
    }


    public function getAllCategory()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM category";
        return $conn->fetchAll($sql);
    }

    public function getAllCategoryEmpty()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM category WHERE status = 0";
        return $conn->fetchAll($sql);
    }
    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
