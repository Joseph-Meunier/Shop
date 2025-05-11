<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Cookie;


class LocaleListener
{
    private string $defaultLocale;
    private const COOKIE_NAME = 'app_locale';
    private const COOKIE_LIFETIME = 31536000; // 1 an en secondes

    public function __construct(string $defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->getRequestType() !== HttpKernelInterface::MAIN_REQUEST) {
            return;
        }

        $request = $event->getRequest();

        // 1. Locale dans l'URL
        if ($locale = $request->attributes->get('_locale')) {
            // rien à faire ici, la locale de l'URL sera utilisée
        }
        // 2. Locale dans le cookie
        elseif ($locale = $request->cookies->get(self::COOKIE_NAME)) {
            if (!in_array($locale, ['en', 'fr'])) {
                $locale = $this->defaultLocale;
            }
            $request->setLocale($locale);
        }
        // 3. Locale par défaut
        else {
            $locale = $this->defaultLocale;
            $request->setLocale($locale);
        }
    }
}

?>