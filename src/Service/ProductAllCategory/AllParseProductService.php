<?php


namespace App\Service\ProductAllCategory;


use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use App\Service\Product\GetPageProduct;
use App\Service\Product\ParseProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllParseProductService extends AbstractController
{
    /**
     * @var ParseProductService
     */
    private $parseProductService;
    /**
     * @var GetPageProduct
     */
    private $getPageProduct;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ProductsRepository
     */
    private $productsRepository;


    public function __construct(ParseProductService $parseProductService, GetPageProduct $getPageProduct, CategoryRepository $categoryRepository, ProductsRepository $productsRepository)
    {

        $this->parseProductService = $parseProductService;
        $this->getPageProduct = $getPageProduct;
        $this->categoryRepository = $categoryRepository;
        $this->productsRepository = $productsRepository;
    }

    public function parseAllProduct()
    {
        $categories = $this->categoryRepository->getAllCategory();
        $status = 0;
        $this->categoryRepository->updateAllStatusCategory($status);
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