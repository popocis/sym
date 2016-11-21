<?php
// src/AppBundle/Entity/UserEvent.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

abstract class ContactMethod
{
    const Phone = 1;
    const Email = 2;
	const Viber = 3;
	const WhatsApp = 4;
}

abstract class ContactReason
{
    const Estimate = 1;
    const AcceptedEstimate = 2;
	const Commercial = 3;
	const General = 4;
}

/**
 * @ORM\Entity
 * @ORM\Table(name="user_event")
 */
class UserEvent
{
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
	 * @Assert\Choice(choices = {"phone", "email", "viber", "whatsapp"}, message = "Choose a valid contact method.")
	 */
	protected $contactMethod;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"general", "commercial", "estimate", "acceptedEstimate"}, message = "Choose a valid contact reason.")
	 */
	protected $contactReason;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date;

	/**
	 * @ORM\Column(type="string", length=255)
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

	public function getDate() {
		return $this->date;
	}

	public function getNotes() {
		return $this->date;
	}

	public function setAdminUser($value) {
		$this->adminUser = $value;
		return $this;
	}

	public function setCustomerUser($value) {
		$this->customerUser = $value;
		return $this;
	}

	public function setContactMethod($value) {
		$this->contactMethod = $value;
		return $this;
	}

	public function setContactReason($value) {
		$this->contactReason = $value;
		return $this;
	}

	public function setDate($value) {
		$this->date = $value;
		return $this;
	}

	public function setNotes($value) {
		$this->notes = $value;
		return $this;
	}
}
