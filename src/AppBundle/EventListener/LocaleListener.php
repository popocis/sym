<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LocaleListener {

	private $tokenStorage;

	public function __construct(TokenStorageInterface $tokenStorage) {
		$this->tokenStorage = $tokenStorage;
	}

	public function onKernelRequest(GetResponseEvent $event) {
		$this->setLocale($event->getRequest());
	}

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
        $token = $event->getAuthenticationToken();

        if (is_object($token)) {
            $user = $token->getUser();
            $request = $event->getRequest();
            $session = $request->getSession();

            $session->set('_locale', $user->getCountryName());
        }
    }

	private function setLocale(Request $request) {
        $locale = $request->getSession()->get('_locale', $request->getDefaultLocale());
        $request->setLocale($locale);
    }
}
