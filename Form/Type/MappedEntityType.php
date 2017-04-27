<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use ThinkBig\Bundle\EntityTransformBundle\Form\DataTransformer\ObjectToMappingTransformer;

class MappedEntityType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $entityManager;
    private $mappingManager;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $mappingManager)
    {

        $this->entityManager    = $entityManager;
        $this->mappingManager   = $mappingManager;
    
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $transformer = new ObjectToMappingTransformer($this->entityManager, $this->mappingManager);
        $builder->addModelTransformer($transformer);

    }

    public function getName()
    {
        return 'mapped_entity';
    }

    public function getParent()
    {
        return HiddenType::class;
    }


}