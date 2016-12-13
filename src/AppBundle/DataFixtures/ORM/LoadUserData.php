<?php
// src/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\ContactMethod;
use AppBundle\Entity\ContactReason;
use AppBundle\Entity\UserEvent;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{

	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager)
	{
		// Get our userManager, you must implement 'ContainerAwareInterface'
		$userManager = $this->container->get('fos_user.user_manager');

		// Create ROLE_SUPER_ADMIN
		$user = $userManager->createUser();
		$user->setUsername('vincenzo.pandico@gmail.com');
		$user->setEmail('vincenzo.pandico@gmail.com');
		$user->setPlainPassword('password');
		//$user->setPassword('$2a$10$H7SpSzqmpWzFNh9whB74eulZZzo7XT7bQ.vvxStKomLfh06AX/ulG');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_SUPER_ADMIN'));
		$user->setName('vincenzo');
		$user->setSurname('pandico');
		$user->setPhonenumber(12345678);
		$user->setStatus('operator');
		$user->setCityName('Como');
		$user->setCountryName('en');
		$user->setDeleted(0);
		// Update the user
		$userManager->updateUser($user, true);

		$user = $userManager->createUser();
		$user->setUsername('dario.zilocchi@gmail.com');
		$user->setEmail('dario.zilocchi@gmail.com');
		$user->setPlainPassword('password');
		//$user->setPassword('$2a$10$H7SpSzqmpWzFNh9whB74eulZZzo7XT7bQ.vvxStKomLfh06AX/ulG');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_SUPER_ADMIN'));
		$user->setName('dario');
		$user->setSurname('zilocchi');
		$user->setPhonenumber(87654321);
		$user->setStatus('operator');
		$user->setCityName('Como');
		$user->setCountryName('it');
		$user->setDeleted(0);
		// Update the user
		$userManager->updateUser($user, true);

		$user = $userManager->createUser();
		$user->setUsername('operatore1@email.com');
		$user->setEmail('operatore1@email.com');
		$user->setPlainPassword('password');
		//$user->setPassword('$2a$10$H7SpSzqmpWzFNh9whB74eulZZzo7XT7bQ.vvxStKomLfh06AX/ulG');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_ADMIN'));
		$user->setName('nome1');
		$user->setSurname('cognome1');
		$user->setPhonenumber(87654321);
		$user->setStatus('operator');
		$user->setCityName('Como');
		$user->setDeleted(0);
		// Update the user
		$userManager->updateUser($user, true);

		for ($i = 1; $i <= 20; $i++) {
			$this->createGenericUser($userManager, 'nome', 'cognome',$i);
		}
	}

	private function createGenericUser($um, $name, $surname, $index) {
		$user = $um->createUser();
		$user->setUsername($name.'.'.$surname.$index.'@email.com');
		$user->setEmail($name.'.'.$surname.$index.'@email.com');
		$user->setPlainPassword('password');
		$user->setEnabled(false);
		$user->setRoles(array('ROLE_USER'));
		$user->setName($name.$index);
		$user->setSurname($surname.$index);
		$user->setPhonenumber(12345678);
		$user->setStatus('commercial');
		$user->setCityName('city name');
		$user->setDeleted(0);
		// Update the user
		$um->updateUser($user, true);

		return $user;
	}
	
}