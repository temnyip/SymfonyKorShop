<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ParseCategoriesController extends AbstractController
{

    /**
     * @Route("/parser/category/", name="parse_category", methods="POST")
     */

    public function index()
    {
        return $this->render('/parser/parseCategory/parseCategory.html.twig', [
            'text' => 'вот ты и тут',
        ]);
    }
}

