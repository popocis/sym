<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener responsible for adding the default user role at registration
 */
class RegistrationListener implements EventSubscriberInterface{

	protected $context;

	public function __construct($context){
		$this->context = $context;
	}

	public static function getSubscribedEvents(){
		return array(
			FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
		);
	}

	public function onRegistrationSuccess(FormEvent $event){

		if($this->context->isGranted('ROLE_SUPER_ADMIN')){
			$rolesArr = array('ROLE_ADMIN');
			$user = $event->getForm()->getData();
			$user->setRoles($rolesArr);
		}
		else if($this->context->isGranted('ROLE_ADMIN')){
			$rolesArr = array('ROLE_USER');
			$user = $event->getForm()->getData();
			$user->setRoles($rolesArr);
		}
	}
}

