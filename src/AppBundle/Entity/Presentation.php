<?php
// src/AppBundle/Entity/Presentation.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="presentation")
 */
class Presentation{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $date;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $place;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $notes;

	public function __construct() {
	}

	public function __toString() {
		return $this->name;
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getDate(){
		return $this->date;
	}

	public function getPlace(){
		return $this->place;
	}

	public function getNotes(){
		return $this->notes;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function setDate($date){
		$this->date = $date;
		return $this;
	}

	public function setPlace($place){
		$this->place = $place;
		return $this;
	}

	public function setNotes($notes){
		$this->notes = $notes;
		return $this;
	}

}
