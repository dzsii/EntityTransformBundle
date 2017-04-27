<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Service;

use ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;

/**
* 
*/
class EntityMappingManager
{

	private $entityManager;
	private $guesser;
	
	/**
     * @param ObjectManager $entityManager
     * @param DoctrineOrmTypeGuesser $guesser
     */
    public function __construct(EntityManager $entityManager, DoctrineOrmTypeGuesser $guesser)
    {

        $this->entityManager    = $entityManager;
        $this->guesser  		= $guesser;
    
    }

    public function getEntityMapping($entity) {

    	// validation: entity::class van-e configban?

    	$class 	= ClassUtils::getClass($entity);
    	$id 	= $entity->getId();

    	$mapping = $this->entityManager->getRepository(Mapping::class)->findOneBy(['objectClass' => $class, 'objectId' => $id]);

    	if (!$mapping) {

    		throw new \Exception(sprintf("Mapping not found for %s:%s", $class, $id));

    	}

    	return $mapping;

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


