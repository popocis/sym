<?php
// src/AppBundle/Entity/FormOrigin.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="form_origin")
 */
class FormOrigin{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $formName;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"IT", "COM", "EU"}, message = "Choose a valid domain.")
	 */
	protected $formDomain;

	public function __construct() {
	}

	public function __toString() {
		return $this->formName;
	}

	public function getId(){
		return $this->id;
	}

	public function getFormName(){
		return $this->formName;
	}

	public function getFormDomain(){
		return $this->formDomain;
	}

	public function setFormName($formName){
		$this->formName = $formName;
		return $this;
	}

	public function setFormDomain($formDomain){
		$this->formDomain = $formDomain;
		return $this;
	}


}
