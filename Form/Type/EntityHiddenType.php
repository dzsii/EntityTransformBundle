<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ThinkBig\Bundle\EntityTransformBundle\Form\DataTransformer\ObjectToIdTransformer;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class EntityHiddenType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $guesser;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, DoctrineOrmTypeGuesser $guesser)
    {
        $this->om = $om;
        $this->guesser = $guesser;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class'         => null,
            'field'         => null
        ));

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ObjectToIdTransformer($this->om);
        $builder->addModelTransformer($transformer);

        if($options['class'] === null) {

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($transformer, $builder) {

                /* @var $form \Symfony\Component\Form\Form */
                $form = $event->getForm();
                $class = $form->getParent()->getConfig()->getDataClass();
                $property = $form->getName();
                $guessedType = $this->guesser->guessType($class, $property);
                $options = $guessedType->getOptions();

                $transformer->setObjectClass($options['class']);

            });

        } else {

            $transformer->setObjectClass($options['class']);

        }

        $transformer->setObjectField($options['field'] ? $options['field'] : 'id');


    }

    public function getName()
    {
        return 'entity_hidden';
    }

    public function getParent()
    {
        return 'hidden';
    }


}