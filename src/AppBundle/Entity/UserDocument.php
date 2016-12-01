<?php
// src/AppBundle/Entity/UserEvent.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class UserDocument
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="admin_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $adminUser;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="client_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $customerUser;


	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"dentalPanoramic", "quote", "document", "other"}, message = "Choose a valid document type.")
	 */
	protected $documentType;

	/**
	 * NOTE: This is not a mapped field of entity metadata, just a simple property.
	 *
	 * @Vich\UploadableField(mapping="user_document", fileNameProperty="documentName")
	 *
	 * @var File
	 */
	protected $documentFile;

	/**
	 * @ORM\Column(type="string", length=255)
	 *
	 * @var string
	 */
	protected $documentName;

	/**
	 * @ORM\Column(type="datetime")
	 *
	 * @var \DateTime
	 */
	protected $uploadAt;

	/**
	 * @ORM\Column(type="datetime")
	 *
	 * @var \DateTime
	 */
	protected $updatedAt;

	public function getId(){
		return $this->id;
	}

	public function getAdminUser(){
		return $this->adminUser;
	}

	public function getCustomerUser(){
		return $this->customerUser;
	}

	public function getDocumentType(){
		return $this->documentType;
	}

	public function getDocumentFile(){
		return $this->documentFile;
	}

	public function getDocumentName(){
		return $this->documentName;
	}

	public function getUploadAt(){
		return $this->uploadAt;
	}

	public function setAdminUser($adminUser){
		$this->adminUser = $adminUser;
		return $this;
	}

	public function setCustomerUser($customerUser){
		$this->customerUser = $customerUser;
		return $this;
	}

	public function setDocumentType($documentType){
		$this->documentType = $documentType;
		return $this;
	}

	public function setDocumentFile(File $documentFile = null){
		$this->documentFile = $documentFile;
		if ($documentFile) {
			// It is required that at least one field changes if you are using doctrine
			// otherwise the event listeners won't be called and the file is lost
			$this->updatedAt = new \DateTime('now');
		}
		return $this;
	}

	public function setUploadAt($uploadAt){
		$this->uploadAt = $uploadAt;
		return $this;
	}

	public function setDocumentName($documentName){
		$this->documentName = $documentName;
		return $this;
	}
}
