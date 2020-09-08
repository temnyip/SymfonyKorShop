<?php


namespace App\Service\Product;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParseProductService
{
    /**
     * @var ProductsRepository
     */
    private $productsRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var GetPageProduct
     */
    private $getPageProduct;

    public function __construct(ProductsRepository $productsRepository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, GetPageProduct $getPageProduct)
    {

        $this->productsRepository = $productsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
        $this->getPageProduct = $getPageProduct;
    }

    public function parse($id)
    {
        $status = 0;
        $this->categoryRepository->saveCategoryStatus($status, $id); //перезаписываем status с 1 на 0
        $categories = $this->entityManager->find(Category::class, $id);
        $url = $categories->getUri();
        $products = $this->getPageProduct->parserKorShopPage($url);
        if (!empty($products)) {
            foreach ($products as &$data) {
                $data['category_id'] = $id;
            }
            $this->productsRepository->removeAllProducts($id); //удаляем все продукты под полученным id
        }
        foreach ($products as $product) {
            $this->productsRepository->saveProduct($product);
        }
        if (!empty($products)) {
            $status = 1;
            $this->categoryRepository->saveCategoryStatus($status, $id);
        }
        if(!empty($categories)) {
            header("Location: /category/id");
        } else {
            echo "Данные не получены";
        }
                dd($products);
    }
}