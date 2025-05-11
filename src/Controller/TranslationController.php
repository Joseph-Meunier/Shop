<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

final class TranslationController extends AbstractController
{

    #[Route('/change-locale/{locale}', name: 'app_change_locale')]
    public function changeLocale(string $locale, Request $request): Response
    {
        if (!in_array($locale, ['en', 'fr'])) {
            throw $this->createNotFoundException('Locale non supportée');
        }

        $response = $this->redirect($request->headers->get('referer') ?? $this->generateUrl('app_home'));
        $response->headers->setCookie(new Cookie(
            'app_locale',
            $locale,
            time() + 31536000, // 1 an
            '/',
            null,
            true,  // secure
            true   // httpOnly
        ));

        return $response;
    }
    
}