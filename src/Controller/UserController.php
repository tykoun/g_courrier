<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/new", name="user_new")
     */
    public function create(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder) 
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid() ){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $service = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L’<strong>utilisateur</strong> a été bien ajouter "
            );

            return $this->redirectToRoute('user');
        }
        
       return $this->render("user/add.html.twig", [
           'form' => $form->createView()
       ]);
    }


    /**
     * @Route("/user/{id}/edit", name="user_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,User $user) 
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($user);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "La modification de l’<strong>utilisateur</strong> a été bien reçu avec succès "
            );

            return $this->redirectToRoute('user');
        }
        
       return $this->render("user/add.html.twig", [
           'form' => $form->createView()
       ]);
    }

     /**
     * @Route("/user/{id}/delete", name = "user_delete")
     */
    public function delete(EntityManagerInterface $manager, user $user)
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('user');
    } 

}
