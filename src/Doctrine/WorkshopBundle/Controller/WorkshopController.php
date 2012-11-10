<?php

namespace Doctrine\WorkshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class WorkshopController extends Controller
{
    public function indexAction()
    {
        $reflection = new \ReflectionObject($this);
        $routeNames = array();

        foreach ($reflection->getMethods() as $method) {
            if (substr($method->getName(), -6) == "Action") {
                $routeNames[] = strtolower(str_replace("Action", "", $method->getName()));
            }
        }

        return $this->render('DoctrineWorkshopBundle:Workshop:index.html.twig', array(
            'routeNames' => $routeNames,
        ));
    }
}


