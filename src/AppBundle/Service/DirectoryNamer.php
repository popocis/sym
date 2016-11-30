<?php

namespace AppBundle\Service;

use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use AppBundle\Entity\UserDocument;

class DirectoryNamer implements DirectoryNamerInterface{
	public function directoryName($userDocument, PropertyMapping $mapping){
		$user = $userDocument->getCustomerUser();
		$userId = $user->getId();
		//$mediaType = $userDocument->getType()->toString();
		return $userId.'/';
	}
}