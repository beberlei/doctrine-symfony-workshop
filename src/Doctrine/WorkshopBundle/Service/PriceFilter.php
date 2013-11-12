<?php
namespace Doctrine\WorkshopBundle\Service;

use Doctrine\ORM\Mapping\ClassMetadata,
    Doctrine\ORM\Query\Filter\SQLFilter;

class PriceFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->name === 'Doctrine\WorkshopBundle\Entity\Vehicle') {
            return $targetTableAlias . '.price < 20';
        }

        return '';
    }
}
