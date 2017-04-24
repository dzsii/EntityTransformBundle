<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mapping
 *
 * @ORM\Table(name="ThinkBig_EntityTransformBundle_Mapping")
 * @ORM\Entity(repositoryClass="ThinkBig\Bundle\EntityTransformBundle\Model\MappingRepository")
 */
class Mapping
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="objectClass", type="string", length=255)
     */
    private $objectClass;

    /**
     * @var integer
     *
     * @ORM\Column(name="objectId", type="integer")
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(name="mapping", type="string", length=255, nullable=true)
     */
    private $mapping;


    public function __construct() {
    
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set objectClass
     *
     * @param string $objectClass
     * @return Mapping
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    /**
     * Get objectClass
     *
     * @return string 
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return Mapping
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Gets the value of mapping.
     *
     * @return string
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * Sets the value of mapping.
     *
     * @param string $mapping the mapping
     *
     * @return self
     */
    public function setMapping($mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }




}