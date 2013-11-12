<?php

namespace Doctrine\WorkshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\WorkshopBundle\Entity\Vehicle;
use Doctrine\WorkshopBundle\Entity\Brand;
use Doctrine\WorkshopBundle\Entity\Image;
use Doctrine\WorkshopBundle\Form\Type\VehicleType;

class WorkshopController extends Controller
{
    const IMAGE = <<<CAR
/__\
o  o
CAR;
    public function updateAction(Request $request)
    {
        $vehicle = $this->findVehicle($request);

        $vehicle->setPrice($vehicle->getPrice() * 2);

        $entityManager = $this->getEntityManager();
        $entityManager->flush();

        return $this->gotoVehicle($vehicle);
    }

    public function batchAction()
    {
        $entityManager = $this->getEntityManager();

        $brand = $entityManager
            ->getRepository('Doctrine\WorkshopBundle\Entity\Brand')
            ->findOneBy(array('name' => 'AUDI')) ?: new Brand('AUDI');

        $entityManager->persist($brand);

        for ($i = 0; $i < 5; $i++) {
            $vehicle = new Vehicle();
            $vehicle->brand = $brand;
            $vehicle->setOffer('AUDI A' . $i);
            $vehicle->setPrice(10 * $i);
            $vehicle->zulassungsdatum = new \DateTime(sprintf('1999-%02d-01', $i));

            for ($j = 0; $j < 3; $j++) {
                $image = new Image();
                $image->setData(self::IMAGE);
                $vehicle->addImage($image);

                $entityManager->persist($image);
            }

            $entityManager->persist($vehicle);
        }

        $brand = $entityManager
            ->getRepository('Doctrine\WorkshopBundle\Entity\Brand')
            ->findOneBy(array('name' => 'BMW')) ?: new Brand('BMW');

        $entityManager->persist($brand);

        for ($i = 0; $i < 5; $i++) {
            $vehicle = new Vehicle();
            $vehicle->brand = $brand;
            $vehicle->setOffer('BMW ' . $i . 'er');
            $vehicle->setPrice(10 * $i);
            $vehicle->zulassungsdatum = new \DateTime(sprintf('1999-%02d-01', $i));

            for ($j = 0; $j < 3; $j++) {
                $image = new Image();
                $image->setData(self::IMAGE);
                $vehicle->addImage($image);

                $entityManager->persist($image);
            }

            $entityManager->persist($vehicle);
        }

        $entityManager->flush(array($vehicle, ...));

        return $this->gotoList();
    }

    public function listAction()
    {
        $builder = $this->getEntityManager()->createQueryBuilder();

        $builder
            ->select('v, b')
            ->from('Doctrine\WorkshopBundle\Entity\Vehicle', 'v')
            ->innerJoin('v.brand', 'b')
            ->orderBy('v.id', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(20);

        $vehicles = $builder->getQuery()->getREsult();

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

    public function showImageAction($vehicleId, $imageId)
    {
        $vehicle = $this->findVeicle($vehicleId);
        return new Response($vehicle->images[$imageId]->getData());
    }

    public function createAction(Request $request)
    {
        $vehicle = new Vehicle();

        return $this->handleVehicleForm($vehicle, $request);
    }

    protected function findVehicle(Request $request)
    {
        $vehicle = $this->getEntityManager()->find('Doctrine\WorkshopBundle\Entity\Vehicle', $request->query->get('id'));
        /*$vehicle = $this->getEntityManager()->find('Doctrine\WorkshopBundle\Entity\Vehicle', $request->query->get('id'));

        $vehicle =
            $this->getEntityManager()
                ->getRepository('Doctrine\WorkshopBundle\Entity\Vehicle')
                ->findOneBy(array('offer'=>  $vehicle->getOffer()));*/

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


