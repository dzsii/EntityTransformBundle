<?php

// src/AppBundle/EventListener/SearchIndexer.php
namespace ThinkBig\Bundle\EntityTransformBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Profile;

use ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping;
use Doctrine\Common\Util\ClassUtils;

class EntityMappingListener
{
    public function postPersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        // only act on some "Product" entity
        if (!$entity instanceof Profile) {
            return;
        }

        $entityManager = $args->getEntityManager();
        // ... do something with the Product

        $mapping 	= new Mapping();
		
		$mapping->setObjectClass(ClassUtils::getClass($entity));
		$mapping->setObjectId($entity->getId());

		$entityManager->persist($mapping);
		$entityManager->flush();


    }
}