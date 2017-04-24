<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Service;

use ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping;
use Doctrine\Common\Util\ClassUtils;

/**
* 
*/
class EntityMappingManager
{

	private $em;
	
	function __construct($doctrine)
	{
		
		$this->em = $doctrine->getManager();

	}

	public function addResource($object, $context = null) {

		$mapping 	= new Mapping();
		
		$mapping->setObjectClass(ClassUtils::getClass($object));
		$mapping->setObjectId($object->getId());

		if ($context) {

			$mapping->setMapping($context);

		}

		$this->em->persist($mapping);

		return $mapping;

	}

}


