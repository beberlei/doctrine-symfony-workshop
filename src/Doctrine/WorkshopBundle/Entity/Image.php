<?php

namespace Doctrine\WorkshopBundle\Entity;

class Image
{
    protected $id;
    protected $vehicle;
    protected $data;

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
