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
	 *     min=3,
	 *     max=255,
	 *     minMessage="Surname is too short.",
	 *     maxMessage="Surname is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $surname;

	/**
	 * @ORM\Column(type="integer", length=255)
	 *
	 * @Assert\NotBlank(message="Please enter phone number.", groups={"Registration", "Profile"})
	 * @Assert\Length(
	 *     min=6,
	 *     max=20,
	 *     minMessage="Phone number is too short.",
	 *     maxMessage="Phone number is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 * @Assert\Regex(pattern="/^[0-9]{6,20}$/", message="Not valid number")
	 */
	protected $phoneNumber;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"commercial", "prospect", "client", "operator"}, message = "Choose a valid user status.")
	 */
	protected $status;

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

	public function getPhoneNumber(){
		return $this->phoneNumber;
	}

	public function getStatus(){
		return $this->status;
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

	public function setPhoneNumber($phoneNumber){
		$this->phoneNumber = $phoneNumber;
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