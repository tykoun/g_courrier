<?php

namespace App\Controller;

use App\Entity\Signature;
use App\Form\SignatureType;
use App\Repository\SignatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SignatureController extends AbstractController
{
    /**
     * @Route("/signature", name="signature")
     */
    public function index(SignatureRepository $signatureRepository): Response
    {
        return $this->render('signature/index.html.twig', [
            'signatures' => $signatureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/signature/ajout", name="signature_new")
     */
    public function create(Request $request,EntityManagerInterface $manager)
    {
        $signature = new Signature();
        $form = $this->createForm(SignatureType::class, $signature);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($signature);
            $manager->flush();

            return $this->redirectToRoute('signature');
        }

        return $this->render("signature/add.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/signature/{id}/edit", name="signature_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Signature $signature)
    {
        $form = $this->createForm(SignatureType::class, $signature);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($signature);
            $manager->flush();

            return $this->redirectToRoute('signature');
        }

        return $this->render("signature/add.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/signature/{id}/delete", name="signature_delete")
     */
    public function delete(EntityManagerInterface $manager,Signature $signature)
    {
        $manager->remove($signature);
        $manager->flush();
        return $this->redirectToRoute('signature');
    }
}
