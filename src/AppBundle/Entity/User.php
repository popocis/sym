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
	}

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
	 * @Assert\Length(
	 *     min = 2,
     *     max = 50,
     *     minMessage = "Your first name must be at least {{ limit }} characters long",
     *     maxMessage = "Your first name cannot be longer than {{ limit }} characters"
	 * )
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\NotBlank(message="Please enter your surname.", groups={"Registration", "Profile"})
	 * @Assert\Length(
	 *     min=3,
	 *     max=255,
	 *     minMessage="The surname is too short.",
	 *     maxMessage="The surname is too long.",
	 *     groups={"Registration", "Profile"}
	 * )
	 */
	protected $surname;

	public function getName(){
		return $this->name;
	}

	public function getSurname(){
		return $this->surname;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function setSurname($surname){
		$this->surname = $surname;
		return $this;
	}

	public function setEmail($email){
		$email = is_null($email) ? '' : $email;
		parent::setEmail($email);
		$this->setUsername($email);

		return $this;
	}

}