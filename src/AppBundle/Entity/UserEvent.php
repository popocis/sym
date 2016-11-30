<?php
// src/AppBundle/Entity/UserEvent.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_event")
 */
class UserEvent{
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
	 * @Assert\Choice(choices = {"phone", "email", "viber", "whatsapp", "facetime", "form", "toll free"}, message = "Choose a valid contact method.")
	 */
	protected $contactMethod;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"general", "commercial", "estimate", "accepted estimate"}, message = "Choose a valid contact reason.")
	 */
	protected $contactReason;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=false)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 1
	 * )
	 */
	protected $throughOffering;

	/**
	 * @ORM\Column(type="date")
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

	public function getCustomerUserId() {
		return $this->customerUser;
	}

	public function getContactMethod() {
		return $this->contactMethod;
	}

	public function getContactReason() {
		return $this->contactReason;
	}

	public function getThroughOffering() {
		return $this->throughOffering;
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

	public function setContactMethod($contactMethod) {
		$this->contactMethod = $contactMethod;
		return $this;
	}

	public function setContactReason($contactReason) {
		$this->contactReason = $contactReason;
		return $this;
	}

	public function setThroughOffering($throughOffering) {
		$this->throughOffering = $throughOffering;
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
