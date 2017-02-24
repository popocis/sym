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
	protected $estimateSendDate;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $estimateRecallDate;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 2
	 * )
	 */
	protected $estimateRecallAttempts;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $interestedLaterDate;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 2
	 * )
	 */
	protected $interestedLaterAttempts;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $postTherapyRecallDate;

	/**
	 * @ORM\Column(type="integer", length=1, nullable=true)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 2
	 * )
	 */
	protected $postTherapyRecallAttempts;


	public function __construct() {
	}

	public function getId() {
		return $this->id;
	}

	public function getCustomerUser() {
		return $this->customerUser;
	}

	public function getEstimateSendDate() {
		return $this->estimateSendDate;
	}

	public function getEstimateRecallDate() {
		return $this->estimateRecallDate;
	}

	public function getEstimateRecallAttempts() {
		return $this->estimateRecallAttempts;
	}

	public function getInterestedLaterDate() {
		return $this->interestedLaterDate;
	}

	public function getInterestedLaterAttempts() {
		return $this->interestedLaterAttempts;
	}

	public function getPostTherapyRecallDate() {
		return $this->postTherapyRecallDate;
	}

	public function getPostTherapyRecallAttempts() {
		return $this->postTherapyRecallAttempts;
	}


	public function setCustomerUser($customerUser) {
		$this->customerUser = $customerUser;
		return $this;
	}

	public function setEstimateSendDate($estimateSendDate) {
		$this->estimateSendDate = $estimateSendDate;
		return $this;
	}

	public function setEstimateRecallDate($estimateRecallDate) {
		$this->estimateRecallDate = $estimateRecallDate;
		return $this;
	}

	public function setEstimateRecallAttempts($estimateRecallAttempts) {
		$this->estimateRecallAttempts = $estimateRecallAttempts;
		return $this;
	}

	public function setInterestedLaterDate($interestedLaterDate) {
		$this->interestedLaterDate = $interestedLaterDate;
		return $this;
	}

	public function setInterestedLaterAttempts($interestedLaterAttempts) {
		$this->interestedLaterAttempts = $interestedLaterAttempts;
		return $this;
	}

	public function setPostTherapyRecallDate($postTherapyRecallDate) {
		$this->postTherapyRecallDate = $postTherapyRecallDate;
		return $this;
	}

	public function setPostTherapyRecallAttempts($postTherapyRecallAttempts) {
		$this->postTherapyRecallAttempts = $postTherapyRecallAttempts;
		return $this;
	}
}
