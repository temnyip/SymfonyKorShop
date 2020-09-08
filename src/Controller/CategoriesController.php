<?php


namespace App\Controller;


use App\Entity\Category;
use App\Service\GetCategoriesHttp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @return Response
     * @Route("/category/id", name="category_show")
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $forRender['categories'] = $categories;
        return $this->render('categories/category.html.twig', $forRender);
    }


}