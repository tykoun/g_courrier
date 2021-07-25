<?php

namespace App\Controller;

use App\Repository\CourrierRepository;
use App\Repository\DirectionRepository;
use App\Repository\DocumentRepository;
use App\Repository\DossierRepository;
use App\Repository\SignatureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(CourrierRepository $courrierRepository, DirectionRepository $directionRepository, DocumentRepository $documentRepository, DossierRepository $dossierRepository, UserRepository $userRepository, SignatureRepository $signatureRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('security_login');
        }

        $users = count($userRepository->findAll());
        $courriers = count($courrierRepository->findAll());
        $directions = count($directionRepository->findAll());
        $documents = count($documentRepository->findAll());
        $dossiers = count($dossierRepository->findAll());
        $signatures = count($signatureRepository->findAll());

        return $this->render('home/dashboard.html.twig', [
            'users' => $users,
            'courriers' => $courriers,
            'directions' => $directions,
            'documents' => $documents,
            'dossiers' => $dossiers,
            'signatures' => $signatures,
        ]);
    }

    /**
     * @Route("/home",name="home")
     */
    public function home(){
        return $this->render('home/index.html.twig');
    }
}
