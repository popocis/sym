<?php
// src/UserBundle/DataFixtures/ORM/LoadClinicData.php

namespace AppBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Clinic;

class LoadClinicData implements OrderedFixtureInterface, ContainerAwareInterface {
	private $container;
	private $em;
	private $clinicRepo;

	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;

		$doctrine = $container->get('doctrine');
		$this->em = $doctrine->getManager();
	}

	public function getOrder() {
        return 2;
    }

	public function load(ObjectManager $manager) {
		$this->addClinic('Clinica Dentalsan', '+385 800177556', '47A', 'Kvarnerska cesta', 'Matulji', 51211, 'Croazia');
		$this->addClinic('Policlinico Kustec', '+385 12306980', 7, 'Bukovačka cesta', 'Zagreb', 10000, 'Croazia');
		$this->addClinic('Clinica Dentale Apolonia', '+385 52647020', 308, 'Tunel Dubrava', 'Labin', 52221, 'Croazia');
	}

	private function addClinic($name, $phoneNumber, $streetNumber, $streetName, $cityName, $zipCode, $countryName) {
		$entity = new Clinic();
		$entity->setName($name);
		$entity->setPhoneNumber($phoneNumber);
		$entity->setStreetNumber($streetNumber);
		$entity->setStreetName($streetName);
		$entity->setCityName($cityName);
		$entity->setZipCode($zipCode);
		$entity->setCountryName($countryName);

		$this->em->persist($entity);
		$this->em->flush();
	}
}
