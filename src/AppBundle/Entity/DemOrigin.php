<?php
// src/AppBundle/Entity/FormOrigin.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="dem_origin")
 */
class DemOrigin{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $demName;

	/**
	 * @ORM\Column(type="integer", length=3, nullable=false)
	 * @Assert\Range(
	 *      min = 0,
	 *      max = 100
	 * )
	 */
	protected $discount;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $notes;

	public function __construct() {
	}

	public function __toString() {
		return $this->demName;
	}

	public function getId(){
		return $this->id;
	}

	public function getDemName(){
		return $this->demName;
	}

	public function getDiscount(){
		return $this->discount;
	}

	public function getNotes(){
		return $this->notes;
	}

	public function setDemName($demName){
		$this->demName = $demName;
		return $this;
	}

	public function setDiscount($discount){
		$this->discount = $discount;
		return $this;
	}

	public function setNotes($notes){
		$this->notes = $notes;
		return $this;
	}

}
