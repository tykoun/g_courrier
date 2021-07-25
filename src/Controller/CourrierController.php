<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Courrier;
use App\Form\CourrierType;
use App\Repository\CourrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class CourrierController
 * @package App\Controller
 */
class CourrierController extends AbstractController
{
    /**
     * @Route("/courrier", name="courrier")
     */
    public function index(CourrierRepository $courrierRepository): Response
    {
        return $this->render('courrier/index.html.twig', [
            'courriers' => $courrierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/courrier/ajout", name="courrier_new")
     */
    public function create(Request $request,EntityManagerInterface $manager)
    {
        $courrier = new Courrier();
        $form = $this->createForm(CourrierType::class, $courrier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $courrier->setSender($this->getUser());

            $manager->persist($courrier);
            $manager->flush();

            $this->addFlash("success", "message envoyé avec succès");

            return $this->redirectToRoute("courrier");
        }

        return $this->render('courrier/add.html.twig', [
            'form' => $form->CreateView()
        ]);
    }

    /**
     * @Route("/courrier/{id}/edit", name="courrier_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Courrier $courrier)
    {
        $form = $this->createForm(CourrierType::class, $courrier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($courrier);
            $manager->flush();

            return $this->redirectToRoute("courrier");
        }

        return $this->render('courrier/add.html.twig', [
            'form' => $form->CreateView()
        ]);
    }

    /**
     * @Route("/courrier/{id}/delete", name="courrier_delete")
     */
    public function delete(EntityManagerInterface $manager,Courrier $courrier)
    {
        $manager->remove($courrier);
        $manager->flush();
        return $this->redirectToRoute('courrier');
    }

    /**
     * @Route("/recu", name="recu")
     */
    public function recu(): Response
    {
        return $this->render('courrier/recu.html.twig');
    }

    /**
     * @Route("/lire/{id}", name="lire")
     */
    public function read(Courrier $courrier): Response
    {
        $courrier->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($courrier);
        $em->flush();
        
        return $this->render("courrier/lire.html.twig", compact("courrier"));
    }
}
