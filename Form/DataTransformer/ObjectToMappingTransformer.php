<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

use ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping;

class ObjectToMappingTransformer implements DataTransformerInterface
{
     /**
     * @var ObjectManager
     */
    private $entityManager;
    private $mappingManager;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager, $mappingManager)
    {
        
        $this->entityManager    = $entityManager;
        $this->mappingManager   = $mappingManager;

    }

    /**
     * Transforms an object to an id.
     *
     * @param  Object|null $object
     * @return mixed
     */
    public function transform($object)
    {

        if (null === $object) {

            return '';
        }

        if($object instanceof Mapping) {

            return $object->getId();

        }
        try {
        
            $mapping = $this->mappingManager->getEntityMapping($object);
            
        } catch (\Exception $e) {

            throw new TransformationFailedException($e->getMessage());
            
        }

        return $mapping->getId();

    }

    /**
     * Transforms an identifier to an object.
     *
     * @param  mixed $value
     *
     * @return Object|null
     *
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($value)
    {
        if (!$value) {

            return null;
        }

        $object = $this->entityManager->getRepository(Mapping::class)->find($value);

        if (null === $object) {

            throw new TransformationFailedException(sprintf('A mapping with "%s" id does not exist!', $value));
        
        }

        return $object;
    }

}
