<?php


namespace App\Service\ProductParseEmptyCells;


use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use App\Service\Product\GetPageProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParseEmptyCells extends AbstractController
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var GetPageProduct
     */
    private $getPageProduct;
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    public function __construct(CategoryRepository $categoryRepository, GetPageProduct $getPageProduct, ProductsRepository $productsRepository)
    {

        $this->categoryRepository = $categoryRepository;
        $this->getPageProduct = $getPageProduct;
        $this->productsRepository = $productsRepository;
    }

    public function parseEmpty()
    {
        $categories = $this->categoryRepository->getAllCategoryEmpty();
        foreach ($categories as $category) {
            $id = $category['id'];
            $url = $category['uri'];;
            $products = $this->getPageProduct->parserKorShopPage($url);
            if (!empty($products)) {
                foreach ($products as &$data) {
                    $data['category_id'] = $id;
                }
                $this->productsRepository->removeAllProducts($id);
                foreach ($products as $product) {
                    $this->productsRepository->saveProduct($product);
                    if (!empty($product)) {
                        $status = 1;
                        $this->categoryRepository->saveCategoryStatus($status, $id);
                    }
                }
            }
        }
        header("Location: /category/id");
    }
}