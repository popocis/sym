<?php
// src/UserBundle/DataFixtures/ORM/LoadUserJourneyData.php

namespace AppBundle\DataFixtures\ORM;

use DateTime;
use DateInterval;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\UserJourney;

class LoadUserJourneyData implements OrderedFixtureInterface, ContainerAwareInterface {
	private $container;
	private $em;
	private $userRepo;
	private $clinicRepo;
	private $userJourneyRepo;

	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;

		$doctrine = $container->get('doctrine');

		$this->em = $doctrine->getManager();
		$this->userRepo = $doctrine->getRepository('AppBundle:User');
		$this->clinicRepo = $doctrine->getRepository('AppBundle:Clinic');
		$this->userJourneyRepo = $doctrine->getRepository('AppBundle:UserJourney');
	}

	public function getOrder() {
        return 2;
    }

	public function load(ObjectManager $manager) {
		$adminUser = $this->userRepo->findOneBy(array('username' => 'dario.zilocchi@gmail.com'));
		$customerUser1 = $this->userRepo->findOneBy(array('username' => 'client1@email.com'));
		$customerUser2 = $this->userRepo->findOneBy(array('username' => 'client2@email.com'));
		$clinic = $this->clinicRepo->findOneBy(array('name' => 'Clinica Dentalsan'));

		$date = new DateTime();

		$date->add(new DateInterval('P1D'));
		$this->addUserJourney($adminUser, $customerUser1, $clinic, $date);

		$date->add(new DateInterval('P3D'));
		$this->addUserJourney($adminUser, $customerUser2, $clinic, $date);

		$date->add(new DateInterval('P5D'));
		$this->addUserJourney($adminUser, $customerUser1, $clinic, $date);

		$date->add(new DateInterval('P1D'));
		$this->addUserJourney($adminUser, $customerUser2, $clinic, $date);
	}

	private function addUserJourney($adminUser, $customerUser1, $clinic, $date) {
		$appointmentDate = clone $date;
		$appointmentDate->add(new DateInterval('P1D'));

		$departureDate = clone $appointmentDate;
		$departureDate->add(new DateInterval('P4D'));

		$entity = new UserJourney();
		$entity->setAdminUser($adminUser);
		$entity->setCustomerUser($customerUser1);
		$entity->setClinic($clinic);
		$entity->setArrivalDate($date);
		$entity->setAppointmentDate($appointmentDate);
		$entity->setDepartureDate($departureDate);

		$this->em->persist($entity);
		$this->em->flush();
	}
}
