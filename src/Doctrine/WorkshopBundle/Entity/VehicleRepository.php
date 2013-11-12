<?php

namespace Doctrine\WorkshopBundle\Entity;

use Doctrine\ORM\EntityRepository;

class VehicleRepository extends EntityRepository
{
    public function getComplexVehicleQuery()
    {
        $query = $this->em->createQuery($dql);
        //...
        //
        return $query;
    }
}


public function listAction()
{
    $query = $repository->getComplexVehicleQuery();

    $pagerfanta = new Pagerfanta(new DoctrineORMQuery($query));
    $pagerfanta->setcurrentPage(1);
    $pagerfanta->setResults(10);
}
