<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener responsible for adding the default user role at registration
 */
class RegistrationListener implements EventSubscriberInterface {

	protected $context;
	protected $tokenGenerator;

	public function __construct($context, $tokenGenerator) {
		$this->context = $context;
		$this->tokenGenerator = $tokenGenerator;
	}

	public static function getSubscribedEvents() {
		return array(
			FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
			FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
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
			$rolesArr = array('ROLE_ADMIN');
			$user->setRoles($rolesArr);
		} else if ($this->context->isGranted('ROLE_ADMIN')) {
			$rolesArr = array('ROLE_USER');
			$user->setRoles($rolesArr);
		}
	}
}
