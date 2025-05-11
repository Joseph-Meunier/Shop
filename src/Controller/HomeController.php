<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, TranslatorInterface $translator): Response
    {
        
        $message = $translator->trans('welcome');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => $message,
            'current_locale' => $request->getLocale(),
        ]);
    }

    #[Route('/catalog', name: 'app_catalog')]
    public function catalog(Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
    {
        $message = $translator->trans('products');

        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('home/catalog.html.twig', [
            'message' => $message,
            'current_locale' => $request->getLocale(),
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function product(Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('home/product.html.twig', [
            'product' => $product,
            'current_locale' => $request->getLocale(),
        ]);
    }

    #[Route('/debug', name: 'app_debug')]
    public function debug(Request $request): Response
    {
        dd($request);
        return $this->render('home/debug.html.twig');
    }


}
