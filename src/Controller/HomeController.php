<?php


namespace App\Controller;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $forRender['categories'] = $categories;
        return $this->render('parser/parser.html.twig', $forRender);
    }
}