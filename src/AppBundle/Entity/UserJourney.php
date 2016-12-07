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
	 * @ORM\ManyToOne(targetEntity="Clinic")
	 * @ORM\JoinColumn(name="clinic_id", referencedColumnName="id", nullable=false)
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
	 * @Assert\Length(
	 *     min = 3,
	 *     max = 255,
	 *     minMessage = "Accommodation info must be at least {{ limit }} characters long",
	 *     maxMessage = "Accommodation info cannot be longer than {{ limit }} characters"
	 * )
	 */
	protected $accommodation;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\Length(
	 *     min = 3,
	 *     max = 255,
	 *     minMessage = "Accommodation address info must be at least {{ limit }} characters long",
	 *     maxMessage = "Accommodation address info cannot be longer than {{ limit }} characters"
	 * )
	 */
	protected $accommodationAddress;

	/**
	 * @ORM\Column(type="integer", length=3, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 100
	 * )
	 */
	protected $nightLoadClient;

	/**
	 * @ORM\Column(type="integer", length=3, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 100
	 * )
	 */
	protected $nightLoadHc;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $transportLoadClient;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $transportLoadHc;

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

	public function getAccommodation() {
		return $this->accommodation;
	}

	public function getAccommodationAddress() {
		return $this->accommodationAddress;
	}

	public function getNightLoadClient() {
		return $this->nightLoadClient;
	}

	public function getNightLoadHc() {
		return $this->nightLoadHc;
	}

	public function getTransportLoadClient() {
		return $this->transportLoadClient;
	}

	public function getTransportLoadHc() {
		return $this->transportLoadHc;
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

	public function setAccommodation($accommodation) {
		$this->accommodation = $accommodation;
		return $this;
	}

	public function setAccommodationAddress($accommodationAddress) {
		$this->accommodationAddress = $accommodationAddress;
		return $this;
	}

	public function setNightLoadClient($nightLoadClient) {
		$this->nightLoadClient = $nightLoadClient;
		return $this;
	}

	public function setNightLoadHc($nightLoadHc) {
		$this->nightLoadHc = $nightLoadHc;
		return $this;
	}

	public function setTransportLoadClient($transportLoadClient) {
		$this->transportLoadClient = $transportLoadClient;
		return $this;
	}

	public function setTransportLoadHc($transportLoadHc) {
		$this->transportLoadHc = $transportLoadHc;
		return $this;
	}

	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
}
