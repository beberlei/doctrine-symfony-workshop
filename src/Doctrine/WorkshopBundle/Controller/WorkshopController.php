<?php

namespace Doctrine\WorkshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\WorkshopBundle\Entity\Vehicle;
use Doctrine\WorkshopBundle\Form\Type\VehicleType;

class WorkshopController extends Controller
{
    public function listAction()
    {
        $vehicles = $this->getEntityManager()
                         ->getRepository('Doctrine\WorkshopBundle\Entity\Vehicle')
                         ->findBy(array(), array('id' => 'DESC'), 20);

        return $this->render('DoctrineWorkshopBundle:Workshop:list.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    public function showAction(Request $request)
    {
        $vehicle = $this->findVehicle($request);

        return $this->render('DoctrineWorkshopBundle:Workshop:show.html.twig', array(
            'vehicle' => $vehicle,
        ));
    }

    public function createAction(Request $request)
    {
        $vehicle = new Vehicle();

        return $this->handleVehicleForm($vehicle, $request);
    }

    protected function findVehicle(Request $request)
    {
        $vehicle = $this->getEntityManager()->find('Doctrine\WorkshopBundle\Entity\Vehicle', $request->query->get('id'));

        if (!$vehicle) {
            throw $this->createNotFoundHttpException();
        }

        return $vehicle;
    }

    public function editAction(Request $request)
    {
        $vehicle = $this->findVehicle($request);

        return $this->handleVehicleForm($vehicle, $request);
    }

    protected function gotoVehicle(Vehicle $vehicle)
    {
        return $this->redirect($this->generateUrl('show', array('id' => $vehicle->getId())));
    }

    protected function gotoList()
    {
        return $this->redirect($this->generateUrl('list'));
    }

    protected function handleVehicleForm($vehicle, Request $request)
    {
        $form = $this->createForm(new VehicleType(), $vehicle);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $entityManager = $this->getEntityManager();
                $entityManager->persist($vehicle);
                $entityManager->flush();

                return $this->gotoList();
            }
        }

        return $this->render('DoctrineWorkshopBundle:Workshop:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->container->get('doctrine.orm.default_entity_manager');
    }
}


