<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class ObjectToIdTransformer implements DataTransformerInterface
{
     /**
     * @var ObjectManager
     */
    private $om;
    private $objectClass;
    private $objectField;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $objectClass = null)
    {
        $this->om = $om;
        $this->objectClass = $objectClass;
        $this->objectField = 'id';
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

        $method = sprintf('get%s', ucfirst($this->objectField));

        return $object->$method();
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

        $object = $this->om
            ->getRepository($this->objectClass)
            ->findOneBy(array($this->objectField => $value))
        ;

        if (null === $object) {

            throw new TransformationFailedException(sprintf(
                'An instance of "%s" with %s "%s" does not exist!',
                $this->objectClass,
                $this->objectField,
                $value
            ));
        }

        return $object;
    }

    public function getObjectClass()
    {
        return $this->objectClass;
    }

    public function setObjectClass($class)
    {
        $this->objectClass = $class;
    }

    /**
     * Gets the value of objectField.
     *
     * @return mixed
     */
    public function getObjectField()
    {
        return $this->objectField;
    }

    /**
     * Sets the value of objectField.
     *
     * @param mixed $objectField the object field
     *
     * @return self
     */
    public function setObjectField($objectField)
    {
        $this->objectField = $objectField;

        return $this;
    }
}
