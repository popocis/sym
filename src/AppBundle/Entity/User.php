<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_hc")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	public function __construct(){
		parent::__construct();
		// your own logic
		$this->registrationDate = new \DateTime();
	}

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\NotBlank(message="Please enter name.", groups={"Registration", "Profile"})
	 * @Assert\Length(
	 *     min = 2,
     *     max = 50,
     *     minMessage = "First name must be at least {{ limit }} characters long",
     *     maxMessage = "First name cannot be longer than {{ limit }} characters"
	 * )
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\NotBlank(message="Please enter surname.", groups={"Registration", "Profile"})
	 * @Assert\Length(
	 *     min=2,
	 *     max=50,
	 *     minMessage="Surname is too short.",
	 *     maxMessage="Surname is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $surname;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $birthDate;

	/**
	 * @ORM\Column(type="string", length=30)
	 *
	 * @Assert\Length(
	 *     min=6,
	 *     max=30,
	 *     minMessage="Phone number is too short.",
	 *     maxMessage="Phone number is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 * @Assert\Regex(pattern="/^[0-9]{6,30}$/", message="Not valid number")
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 *
	 * @Assert\Country
	 */
	protected $countryName;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 *
	 * @Assert\Length(
	 *     min=3,
	 *     max=50,
	 *     minMessage="City name is too short.",
	 *     maxMessage="City name is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $countryRegion;


	/**
	 * @ORM\Column(type="string", length=20, nullable=true)
	 *
	 * @Assert\Length(
	 *     min = 6,
	 *     max = 20,
	 *     minMessage = "Code must be at least {{ limit }} characters long",
	 *     maxMessage = "Code cannot be longer than {{ limit }} characters"
	 * )
	 */
	protected $taxCode;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"prospect", "client", "operator", "agent"}, message = "Choose a valid user status.")
	 */
	protected $status;

	/**
	 * @ORM\ManyToOne(targetEntity="Presentation")
	 * @ORM\JoinColumn(name="presentation_id", referencedColumnName="id", nullable=true)
	 */
	protected $presentation;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $notes;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $registrationDate;

	public function getName(){
		return $this->name;
	}

	public function getSurname(){
		return $this->surname;
	}

	public function getBirthDate() {
		return $this->birthDate;
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

	public function getCountryRegion(){
		return $this->countryRegion;
	}

	public function getTaxCode(){
		return $this->taxCode;
	}

	public function getStatus(){
		return $this->status;
	}

	public function getPresentation(){
		return $this->presentation;
	}

	public function getNotes(){
		return $this->notes;
	}

	public function getRegistrationDate() {
		return $this->registrationDate;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function setSurname($surname){
		$this->surname = $surname;
		return $this;
	}

	public function setBirthDate($birthDate) {
		$this->birthDate = $birthDate;
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

	public function setCountryRegion($countryRegion){
		$this->countryRegion = $countryRegion;
		return $this;
	}

	public function setTaxCode($taxCode){
		$this->taxCode = $taxCode;
		return $this;
	}

	public function setPresentation($presentation){
		$this->presentation = $presentation;
		return $this;
	}

	public function setNotes($notes){
		$this->notes = $notes;
		return $this;
	}

	public function setStatus($status){
		$this->status = $status;
		return $this;
	}

	public function setRegistrationDate($value) {
		$this->registrationDate = $value;
		return $this;
	}

	public function setEmail($email){
		$email = is_null($email) ? '' : $email;
		parent::setEmail($email);
		$this->setUsername($email);
		return $this;
	}

}