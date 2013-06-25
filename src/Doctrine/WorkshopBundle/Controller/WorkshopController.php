<?php

namespace Doctrine\WorkshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\WorkshopBundle\Entity\Vehicle;
use Doctrine\WorkshopBundle\Form\Type\VehicleType;

class WorkshopController extends Controller
{
    public function indexAction()
    {
        return $this->render('DoctrineWorkshopBundle:Workshop:index.html.twig', array());
    }

    public function createAction(Request $request)
    {
        $vehicle = new Vehicle();

        $form = $this->createForm(new VehicleType(), $vehicle);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $entityManager = $this->getEntityManager();
                $entityManager->persist($vehicle);
                $entityManager->flush();

                return $this->redirect($this->generateUrl('index'));
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


