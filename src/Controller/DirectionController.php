<?php

namespace App\Controller;

use App\Entity\Direction;
use App\Form\DirectionType;
use App\Repository\DirectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DirectionController extends AbstractController
{
    /**
     * @Route("/direction", name="direction")
     */
    public function index(DirectionRepository $directioRepository): Response
    {
        return $this->render('direction/index.html.twig', [
            'directions' => $directioRepository->findAll(),
        ]);
    }


    /**
     * @Route("direction/ajout", name="direction_new")
     */
    public function create(Request $request,EntityManagerInterface $manager)
    {
        $direction = new Direction();
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($direction);
            $manager->flush();

            return $this->redirectToRoute("direction");
        }

      return $this->render('direction/add.html.twig', [
          'form'=> $form->CreateView()
      ]);
    }

    /**
     * @Route("/direction/{id}/edit", name="direction_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Direction $direction)
    {
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($direction);
            $manager->flush();

            return $this->redirectToRoute("direction");
        }

      return $this->render('direction/add.html.twig', [
          'form'=> $form->CreateView()
      ]);
    }

    /**
     * @Route("direction/{id}", name="direction_delete")
     */
    public function delete(EntitymanagerInterface $manager, Direction $direction)
    {
        $manager->remove($direction);
        $manager->flush();
        return $this->redirectToRoute('direction');

    }
}
