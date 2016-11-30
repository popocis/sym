<?php
// src/AppBundle/Entity/UserJourney.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_journey")
 */
class UserJourney{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="admin_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $adminUser;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="client_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $customerUser;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"hc Zagabria", "hc Pola"}, message = "Choose a clinic.")
	 */
	protected $clinic;

	/**
	 * @ORM\Column(type="date")
	 */
	protected $arrivalDate;

	/**
	 * @ORM\Column(type="date")
	 */
	protected $appointmentDate;

	/**
	 * @ORM\Column(type="date")
	 */
	protected $departureDate;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $transport;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $structure;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $structureAddress;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $notes;

	public function __construct() {
	}

	public function getId() {
		return $this->id;
	}

	public function getAdminUser() {
		return $this->adminUser;
	}

	public function getCustomerUserId() {
		return $this->customerUser;
	}

	public function getClinic() {
		return $this->clinic;
	}

	public function getArrivalDate() {
		return $this->arrivalDate;
	}

	public function getAppointmentDate() {
		return $this->appointmentDate;
	}

	public function getDepartureDate() {
		return $this->departureDate;
	}

	public function getTransport() {
		return $this->transport;
	}

	public function getStructure() {
		return $this->notes;
	}

	public function getStructureAddress() {
		return $this->notes;
	}

	public function getNotes() {
		return $this->notes;
	}

	public function setAdminUser($adminUser) {
		$this->adminUser = $adminUser;
		return $this;
	}

	public function setCustomerUser($customerUser) {
		$this->customerUser = $customerUser;
		return $this;
	}

	public function setClinic($clinic) {
		$this->clinic = $clinic;
		return $this;
	}

	public function setArrivalDate($arrivalDate) {
		$this->arrivalDate = $arrivalDate;
		return $this;
	}

	public function setAppointmentDate($appointmentDate) {
		$this->appointmentDate = $appointmentDate;
		return $this;
	}

	public function setDepartureDate($departureDate) {
		$this->departureDate = $departureDate;
		return $this;
	}

	public function setTransport($transport) {
		$this->transport = $transport;
		return $this;
	}

	public function setStructure($structure) {
		$this->structure = $structure;
		return $this;
	}

	public function setStructureAddress($structureAddress) {
		$this->structureAddress = $structureAddress;
		return $this;
	}

	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
}
