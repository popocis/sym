<?php
// src/AppBundle/Entity/Quote.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="quote")
 */
class Quote{

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
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_1_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup1;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt1;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare1;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_1_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf1;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt1;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare1;

	/**
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $treatmentTotalFare;

	/**
	 * @ORM\Column(type="date", nullable=false)
	 */
	protected $date;

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

	public function getCustomerUser() {
		return $this->customerUser;
	}

	public function getTreatmentSup1() {
		return $this->treatmentSup1;
	}

	public function getTreatmentSupQt1() {
		return $this->treatmentSupQt1;
	}

	public function getTreatmentSupFare1() {
		return $this->treatmentSupFare1;
	}

	public function getTreatmentInf1() {
		return $this->treatmentInf1;
	}

	public function getTreatmentInfQt1() {
		return $this->treatmentInfQt1;
	}

	public function getTreatmentInfFare1() {
		return $this->treatmentInfFare1;
	}

	public function getTreatmentTotalFare() {
		return $this->treatmentTotalFare;
	}

	public function getDate() {
		return $this->date;
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

	public function setTreatmentSup1($treatmentSup1) {
		$this->treatmentSup1 = $treatmentSup1;
		return $this;
	}

	public function setTreatmentSupQt1($treatmentSupQt1) {
		$this->treatmentSupQt1 = $treatmentSupQt1;
		return $this;
	}

	public function setTreatmentSupFare1($treatmentSupFare1) {
		$this->treatmentSupFare1 = $treatmentSupFare1;
		return $this;
	}

	public function setTreatmentInf1($treatmentInf1) {
		$this->treatmentInf1 = $treatmentInf1;
		return $this;
	}

	public function setTreatmentInfQt1($treatmentInfQt1) {
		$this->treatmentInfQt1 = $treatmentInfQt1;
		return $this;
	}

	public function setTreatmentInfFare1($treatmentInfFare1) {
		$this->treatmentInfFare1 = $treatmentInfFare1;
		return $this;
	}

	public function setTreatmentTotalFare($treatmentTotalFare) {
		$this->treatmentTotalFare = $treatmentTotalFare;
		return $this;
	}

	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
}
