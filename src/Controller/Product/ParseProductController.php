<?php


namespace App\Controller\Product;


use App\Repository\ProductsRepository;
use App\Service\Product\ParseProductService;
use App\Service\ProductAllCategory\AllParseProductService;
use App\Service\ProductParseEmptyCells\ParseEmptyCells;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParseProductController extends AbstractController
{
    /**
     * @var ParseProductService
     */
    private $product;
    /**
     * @var AllParseProductService
     */
    private $allParseProduct;
    /**
     * @var ParseEmptyCells
     */
    private $parseEmptyCells;
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    public function __construct(ParseProductService $product, AllParseProductService $allParseProduct, ParseEmptyCells $parseEmptyCells, ProductsRepository $productsRepository)
    {
        $this->product = $product;
        $this->allParseProduct = $allParseProduct;
        $this->parseEmptyCells = $parseEmptyCells;
        $this->productsRepository = $productsRepository;
    }

    /**
     * @Route("/parser/product", name ="parse_product", methods="POST")
     */
    public function parse(Request $request)
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $id = $request->request->get('category_id');
//        $max = $request->request->get('category_max');
        $this->product->parse($id);
    }

    /**
     * @Route("/parser/product/all", name="parse_product_all", methods="POST")
     */
    public function parseAll()
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $this->allParseProduct->parseAllProduct();
        print_r('Success');
        exit();
    }

    /**
     * @Route("/empty", name="parse_empty", methods="POST")
     */
    public function parseEmptyCells()
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $this->parseEmptyCells->parseEmpty();
        print_r('Success all categories added');
        exit();
    }

    /**
     * @Route("/parse/show/{id}", name="show_id")
     */
    public function showProductId($id)
    {
        $products = $this->productsRepository->getProductById($id);
        $forRender['products'] = $products;
        return $this->render('categories/productShowByCategory.html.twig', $forRender);
    }
}