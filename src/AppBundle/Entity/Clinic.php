<?php
// src/AppBundle/Entity/FormOrigin.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="clinic")
 */
class Clinic{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=30, nullable=true)
	 *
	 * @Assert\Length(
	 *     min=6,
	 *     max=30,
	 *     minMessage="Phone number is too short.",
	 *     maxMessage="Phone number is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 * @Assert\Regex(pattern="/^[0-9]{6,20}$/", message="Not valid number")
	 */
	protected $phoneNumber;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 *
	 * @Assert\Length(
	 *     min=1,
	 *     max=6,
	 *     minMessage="Street number is too short.",
	 *     maxMessage="Street number is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $streetNumber;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 *
	 * @Assert\Length(
	 *     min=1,
	 *     max=50,
	 *     minMessage="Street name is too short.",
	 *     maxMessage="Street name is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $streetName;

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\Length(
	 *     min=3,
	 *     max=50,
	 *     minMessage="City name is too short.",
	 *     maxMessage="City name is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $cityName;

	/**
	 * @ORM\Column(type="string", length=10, nullable=true)
	 *
	 * @Assert\Length(
	 *     min=3,
	 *     max=10,
	 *     minMessage="Zip code is too short.",
	 *     maxMessage="Zip code is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $zipCode;

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\Country
	 */
	protected $countryName;

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
	public function getPhoneNumber(){
		return $this->phoneNumber;
	}

	public function getStreetNumber(){
		return $this->streetNumber;
	}

	public function getStreetName(){
		return $this->streetName;
	}

	public function getCityName(){
		return $this->cityName;
	}

	public function getZipCode(){
		return $this->zipCode;
	}

	public function getCountryName(){
		return $this->countryName;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function setPhoneNumber($phoneNumber){
		$this->phoneNumber = $phoneNumber;
		return $this;
	}

	public function setStreetNumber($streetNumber){
		$this->streetNumber = $streetNumber;
		return $this;
	}

	public function setStreetName($streetName){
		$this->streetName = $streetName;
		return $this;
	}

	public function setCityName($cityName){
		$this->cityName = $cityName;
		return $this;
	}

	public function setZipCode($zipCode){
		$this->zipCode = $zipCode;
		return $this;
	}

	public function setCountryName($countryName){
		$this->countryName = $countryName;
		return $this;
	}

}
