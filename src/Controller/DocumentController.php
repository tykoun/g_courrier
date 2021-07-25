<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class DocumentController extends AbstractController
{
    /**
     * @Route("/document", name="document")
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/document/ajout", name="document_new")
     */
    public function cretate(Request $request,EntityManagerInterface $manager)
    {



        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $file = $form->get("Path")->getData();

            $filePath = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filePath);
            $document->setPath($filePath);



            $manager->persist($document);
            $manager->flush();

            return $this->redirectToRoute('document');
        }


        return $this->render("document/add.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/document/{id}/edit", name="document_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Document $document)
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $file = $form->get("Path")->getData();
            $filePath = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filePath);
            $document->setPath($filePath);


            $manager->persist($document);
            $manager->flush();
            return $this->redirectToRoute('document');
        }

       return $this->render("document/add.html.twig",[
           'form' => $form->createView()
       ]);
    }

    /**
     * @Route("/document/{id}/delete", name ="document_delete")
     */
    public function delete(EntityManagerInterface $manager,Document $document)
    {
        $manager->remove($document);
        $manager->flush();
        return $this->redirectToRoute('document');
    
    }
}
