<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/{id}"), name="categorie")
     */

    public function show(int $id, AnnonceRepository $annonceRepository, CategorieRepository $categorierepository, PaginatorInterface $paginator, Request $request): Response {

        $idcategories = $categorierepository->findMyAnnouncebyCategory($id);

        $idcategories = $paginator->paginate(
            $donnees = $categorierepository->findMyAnnouncebyCategory($id),
            $request->query->getInt('page', 1),
            9 // nb article par page
        );

        return $this->render('categorie/index.html.twig', ['idcategories' => $idcategories,]);
    }
}
