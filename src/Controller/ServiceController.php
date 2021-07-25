<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/service/ajout", name="service_new")
     */
    public function create(Request $request,EntityManagerInterface $manager)
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute('service');
        }

       return $this->render("service/add.html.twig",[
           'form' => $form->createView()
       ]);
    }


    /**
     * @Route("/service/{id}/edit", name="service_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Service $service)
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute('service');
        }

       return $this->render("service/add.html.twig",[
           'form' => $form->createView()
       ]);
    }  
    /**
     * @Route("/service/{id}/delete", name="service_delete")
     */
    public function delete(EntityManagerInterface $manager,Service $service)
    {
        $manager->remove($service);
        $manager->flush();
        
       return $this->redirectToRoute('service');
    }
}
