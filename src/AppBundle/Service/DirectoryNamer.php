<?php

namespace AppBundle\Service;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use AppBundle\Entity\UserDocument;

class DirectoryNamer implements DirectoryNamerInterface{
	/**
	 * Returns the name of a directory where files will be uploaded
	 *
	 * Directory name is formed based on user ID and name and surname
	 *
	 * @param UserDocument $userDocument
	 * @param PropertyMapping $mapping
	 *
	 * @return string
	 */
	public function directoryName($userDocument, PropertyMapping $mapping){
		$user = $userDocument->getCustomerUser();
		$userId = $user->getId();
		//$mediaType = $userDocument->getType()->toString();
		return $userId.'/';
	}
}