<?php

namespace Doctrine\WorkshopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('offer', 'text');
        $builder->add('price', 'integer');
        $builder->add('brand', 'entity', array(
            'class' => 'Doctrine\WorkshopBundle\Entity\Brand',
            'property' => 'name',
            'expanded' => true
        ));
    }

    public function getName()
    {
        return 'vehicle';
    }
}
