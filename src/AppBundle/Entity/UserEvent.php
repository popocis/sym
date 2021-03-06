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
	 * @ORM\JoinColumn(name="admin_user_id", referencedColumnName="id", nullable=true)
	 */
	protected $adminUser;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="client_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $customerUser;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"phone", "email", "viber", "whatsapp", "facebook", "facetime", "facetoface", "form", "other"}, message = "Choose a valid contact method.")
	 */
	protected $contactMethod;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"customer", "operator"}, message = "Choose a valid contact origin.")
	 */
	protected $contactOrigin;

	/**
	 * @ORM\ManyToOne(targetEntity="FormOrigin")
	 * @ORM\JoinColumn(name="form_origin_id", referencedColumnName="id", nullable=true)
	 */
	protected $formOrigin;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"general", "commercial", "panorex", "estimate", "recallestimate", "acceptedestimate", "interestedlater", "recallinterestedlater", "recallposttherapy"}, message = "Choose a valid contact reason.")
	 */
	protected $contactReason;

	/**
	 * @ORM\Column(type="date")
	 */
	protected $date;

	/**
	 * @ORM\Column(type="string", length=500, nullable=true)
	 */
	protected $message;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $estimate;

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

	public function getContactMethod() {
		return $this->contactMethod;
	}

	public function getContactOrigin() {
		return $this->contactOrigin;
	}

	public function getFormOrigin() {
		return $this->formOrigin;
	}

	public function getContactReason() {
		return $this->contactReason;
	}

	public function getDate() {
		return $this->date;
	}

	public function getMessage() {
		return $this->message;
	}

	public function getEstimate() {
		return $this->estimate;
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

	public function setContactOrigin($contactOrigin) {
		$this->contactOrigin = $contactOrigin;
		return $this;
	}

	public function setFormOrigin($formOrigin) {
		$this->formOrigin = $formOrigin;
		return $this;
	}

	public function setContactReason($contactReason) {
		$this->contactReason = $contactReason;
		return $this;
	}

	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	public function setEstimate($estimate) {
		$this->estimate = $estimate;
		return $this;
	}

	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
}
