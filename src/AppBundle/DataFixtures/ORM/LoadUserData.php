<?php
// src/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

		// Update the user
		$userManager->updateUser($user, true);

		// Update the user
		$userManager->updateUser($user, true);

		$user = $userManager->createUser();
		$user->setUsername('dario.zilocchi');
		$user->setEmail('dario.zilocchi@gmail.com');
		$user->setPlainPassword('password');
		//$user->setPassword('$2a$10$H7SpSzqmpWzFNh9whB74eulZZzo7XT7bQ.vvxStKomLfh06AX/ulG');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_SUPER_ADMIN'));

		// Update the user
		$userManager->updateUser($user, true);

		// Update the user
		$userManager->updateUser($user, true);
	}
}