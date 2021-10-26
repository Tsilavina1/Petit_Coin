<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;


class AnnonceController extends AbstractController
{
    /**
    * @Route("/annonce/{id}", name="annonce")
    */
    public function show(int $id): Response
    {
        $product = $this->getDoctrine()
        ->getRepository(Annonce::class)
        ->find($id);

        $products = $this->getDoctrine()
        ->getRepository(Annonce::class)
        ->findAll($id);
        
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        
        // return new Response('Check out this great product: '.$product->getName());
        
        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('annonce/index.html.twig', ['product' => $product, 'products' => $products]);
    }
    
    /**
    * @Route("/mesannonces", name="mesannonces")
    */
    
    public function mesannonces(): Response {
        $user = $this->getUser();
        $annonces = $user->getAnnonces();
        
        return $this->render('annonce/mesannonces.html.twig', [
            'annonces' => $annonces,
        ]);
        
        
    }
    
    /**
    * @Route("/mesannonces/{id}/edit", name="annonce_edit", methods={"GET","POST"})
    */
    public function edit(Request $request, Annonce $annonce, FileUploader $fileUploader): Response {

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $annonce->setImage($imageFileName);
            }

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();
            
            return $this->redirectToRoute('mesannonces', [], Response::HTTP_SEE_OTHER);
            
        }
        return $this->render('annonce/editannonce.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
            
        ]);
        
    }
    
    
    
    /**
    * @Route("/mesannonces/{id}/delete", name="annonce_delete", methods={"GET","POST"})
    */
    public function delete(Request $request, Annonce $annonce): Response{
        
        
        // if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        // }
        
        return $this->redirectToRoute('mesannonces', [], Response::HTTP_SEE_OTHER);
    }
    
    
    
    
}
