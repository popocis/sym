<?php
// src/AppBundle/Entity/Alert.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="alert")
 */
class Alert{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\OneToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="client_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $customerUser;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $registrationDate;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $firstContact;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 3
	 * )
	 */
	protected $firstContactAttempts;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $appointmentDate;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $appointment;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 3
	 * )
	 */
	protected $appointmentAttempts;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $appointmentAfter;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 3
	 * )
	 */
	protected $appointmentAfterAttempts;

	public function __construct() {
	}

	public function getId() {
		return $this->id;
	}

	public function getCustomerUser() {
		return $this->customerUser;
	}

	public function getRegistrationDate() {
		return $this->registrationDate;
	}

	public function getFirstContact() {
		return $this->firstContact;
	}

	public function getFirstContactAttempts() {
		return $this->firstContactAttempts;
	}

	public function getAppointmentDate() {
		return $this->appointmentDate;
	}

	public function getAppointment() {
		return $this->appointment;
	}

	public function getAppointmentAttempts() {
		return $this->appointmentAttempts;
	}

	public function getAppointmentAfter() {
		return $this->appointmentAfter;
	}

	public function getAppointmentAfterAttempts() {
		return $this->appointmentAfterAttempts;
	}

	public function setCustomerUser($customerUser) {
		$this->customerUser = $customerUser;
		return $this;
	}

	public function setRegistrationDate($registrationDate) {
		$this->registrationDate = $registrationDate;
		return $this;
	}

	public function setFirstContact($firstContact) {
		$this->firstContact = $firstContact;
		return $this;
	}

	public function setFirstContactAttempts($firstContactAttempts) {
		$this->firstContactAttempts = $firstContactAttempts;
		return $this;
	}

	public function setAppointmentDate($appointmentDate) {
		$this->appointmentDate = $appointmentDate;
		return $this;
	}

	public function setAppointment($appointment) {
		$this->appointment = $appointment;
		return $this;
	}

	public function setAppointmentAttempts($appointmentAttempts) {
		$this->appointmentAttempts = $appointmentAttempts;
		return $this;
	}

	public function setAppointmentAfter($appointmentAfter) {
		$this->appointmentAfter = $appointmentAfter;
		return $this;
	}

	public function setAppointmentAfterAttempts($appointmentAfterAttempts) {
		$this->appointmentAfterAttempts = $appointmentAfterAttempts;
		return $this;
	}

}
