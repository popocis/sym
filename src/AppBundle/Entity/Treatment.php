<?php
// src/AppBundle/Entity/Treatment.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="treatment")
 */
class Treatment{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $nameEng;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $description;

	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	protected $descriptionEng;

	/**
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $fare;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $notes;

	public function __construct() {
	}

	public function __toString() {
		return $this->name;
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getNameEng() {
		return $this->nameEng;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getDescriptionEng() {
		return $this->descriptionEng;
	}

	public function getFare() {
		return $this->fare;
	}

	public function getNotes() {
		return $this->notes;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function setNameEng($nameEng) {
		$this->nameEng = $nameEng;
		return $this;
	}

	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	public function setDescriptionEng($descriptionEng) {
		$this->descriptionEng = $descriptionEng;
		return $this;
	}

	public function setFare($fare) {
		$this->fare = $fare;
		return $this;
	}

	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
}
