<?php
// src/AppBundle/Entity/UserEvent.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class ContactMethod
{
    const Phone = 1;
    const Email = 2;
    // etc.
}

abstract class ContactReason
{
    const Estimate = 1;
    const AcceptedEstimate = 2;
    // etc.
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
	 * @ORM\Column(type="integer")
	 */
	protected $contactMethod;

	/**
	 * @ORM\Column(type="integer")
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
