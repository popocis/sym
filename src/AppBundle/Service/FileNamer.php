<?php

namespace AppBundle\Service;

use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use AppBundle\Entity\UserDocument;

class FileNamer implements NamerInterface{
	function name($userDocument, PropertyMapping $mapping){
		$file = $userDocument->getDocumentFile();
		$extension = $file->guessExtension();
		$type = $userDocument->getDocumentType();
		return $type.'_'.uniqid('', false).'.'.$extension;
	}
}