<?php


namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @return Response
     * @Route("/product/id", name="product_show")
     */
    public function showProducts()
    {
        $products = $this->getDoctrine()->getRepository(Products::class)->findAll();
        $forRender['products'] = $products;
        return $this->render('product/index.html.twig', $forRender);
    }
}