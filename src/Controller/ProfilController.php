<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\ProfilType;
use App\Entity\User;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/edit", name="profil_edit")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);
        dump($user);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user->getCoordonnees()); 
            $entityManager->persist($user->getCoordonnees()->getAddress()); 
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('home');
        }

        return $this->render('profil/edit.html.twig', [
            'profil' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil() : Response {
        $user = $this->getUser();

        return $this->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profil/{id}", name="profil_autre")
     */
    public function profil_autre(User $user) : Response {
       

        return $this->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }
    



}
