<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * Listener responsible for adding the default user role at registration
 */
class RegistrationListener implements EventSubscriberInterface {

	protected $context;
	protected $tokenGenerator;
	protected $router;

	public function __construct($context, $tokenGenerator, $router) {
		$this->context = $context;
		$this->tokenGenerator = $tokenGenerator;
		$this->router = $router;
	}

	public static function getSubscribedEvents() {
		return array(
			FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
			FOSUserEvents::REGISTRATION_SUCCESS => ['onRegistrationSuccess', -10]
		);
	}

	public function onRegistrationInitialize(GetResponseUserEvent $event) {
		$user = $event->getUser();
		$password = substr($this->tokenGenerator->generateToken(), 0, 8);
		$user->setPlainPassword($password);
	}

	public function onRegistrationSuccess(FormEvent $event) {
		$user = $event->getForm()->getData();
		if ($this->context->isGranted('ROLE_SUPER_ADMIN')) {
			if($user->getStatus() == "agent"){
				$rolesArr = array('ROLE_AGENT');
			}
			else if($user->getStatus() == "operator"){
				$rolesArr = array('ROLE_ADMIN');
			}
			$user->setRoles($rolesArr);
		} else if ($this->context->isGranted('ROLE_ADMIN')) {
			$rolesArr = array('ROLE_USER');
			$user->setRoles($rolesArr);
		}
		// redirect to dashboard
		$url = $this->router->generate('dashboard');
		$event->setResponse(new RedirectResponse($url));
	}
}
