<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    // /**
    //  * @return Products[] Returns an array of Products objects
    //  */

//    public function findByExampleField($value)
    public function removeAllProduct()
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'DELETE FROM products';
        $conn->executeQuery($sql);

//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
    }

    public function removeAllProducts($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "DELETE FROM products WHERE category_id ='$id'";
        $conn->executeQuery($sql);
    }

    public function saveProduct(array $store) {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO products (title, price, images, url, ends_date, description, category_id) VALUES ('{$store['title']}', '{$store['price']}', '{$store['images']}', '{$store['url']}', '{$store['endsDate']}', '{$store['description']}', '{$store['category_id']}')";
        $conn->executeQuery($sql);
    }

    public function getProductById($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM products WHERE category_id ='$id'";
        return $conn->fetchAll($sql);
    }
    /*
    public function findOneBySomeField($value): ?Products
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
