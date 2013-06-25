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
    }

    public function getName()
    {
        return 'vehicle';
    }
}
