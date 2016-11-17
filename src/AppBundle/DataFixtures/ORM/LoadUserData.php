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
		$user->setUsername('vincenzo.pandico');
		$user->setEmail('vincenzo.pandico@gmail.com');
		$user->setPlainPassword('password');
		//$user->setPassword('$2a$10$H7SpSzqmpWzFNh9whB74eulZZzo7XT7bQ.vvxStKomLfh06AX/ulG');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_SUPER_ADMIN'));
		$user->setName('vincenzo');
		$user->setSurname('pandico');
		$user->setPhonenumber(12345678);
		$user->setStatus(0);

		// Update the user
		$userManager->updateUser($user, true);

		$user = $userManager->createUser();
		$user->setUsername('dario.zilocchi');
		$user->setEmail('dario.zilocchi@gmail.com');
		$user->setPlainPassword('password');
		//$user->setPassword('$2a$10$H7SpSzqmpWzFNh9whB74eulZZzo7XT7bQ.vvxStKomLfh06AX/ulG');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_SUPER_ADMIN'));
		$user->setName('dario');
		$user->setSurname('zilocchi');
		$user->setPhonenumber(87654321);
		$user->setStatus(0);

		// Update the user
		$userManager->updateUser($user, true);


		$adminUser = $user;
		$customerUser = $this->createGenericUser($userManager, 'foo', 'bar'); 
		$event = $this->createGenericUserEvent($manager, $adminUser, $customerUser);
	}

	private function createGenericUser($um, $name, $surname) {
		$user = $um->createUser();

		$user->setUsername($name + '.' + $surname);
		$user->setEmail($name + '.' + $surname + '@gmail.com');
		$user->setPlainPassword('password');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_USER'));
		$user->setName($name);
		$user->setSurname($surname);
		$user->setPhonenumber(12345678);
		$user->setStatus(0);

		$um->updateUser($user, true);

		return $user;
	}

	private function createGenericUserEvent($em, $adminUser, $customerUser) {
		$userEvent = new UserEvent();
		$userEvent->setAdminUser($adminUser);
		$userEvent->setCustomerUser($customerUser);
		$userEvent->setContactMethod(ContactMethod::Phone);
		$userEvent->setContactReason(ContactReason::Estimate);
		$userEvent->setDate(new \DateTime());
		$userEvent->setNotes('Qualche nota priva di senso');

		$em->persist($userEvent);
		$em->flush();

		return $userEvent;
	}
}