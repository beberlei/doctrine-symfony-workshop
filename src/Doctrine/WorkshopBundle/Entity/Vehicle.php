<?php

namespace Doctrine\WorkshopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Vehicle
{
    protected $id;
    protected $offer;
    protected $price;

    public $zulassungsdatum;
    public $brand;
    public $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
        $image->setVehicle($this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOffer()
    {
        return $this->offer;
    }

    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}

