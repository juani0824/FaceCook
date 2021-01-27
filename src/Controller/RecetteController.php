<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Manager\PublicationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RecetteController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/recette", name="recette")
     */
    public function index(PublicationManager $publicationManager): Response
    {
        
        return $this->render('recette/index.html.twig', [
            'controller_name' => 'RecetteController',
            'recettes' => $publicationManager->allRecette(),
            'lastRecettes' => $publicationManager->lastXRecette(),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="recette_detail", requirements={"id":"\d+"}, methods={"GET"})
     */
    public function detail(Publication $publication): Response
    {

        // recuperer les 3 dernier recettes
        $lastRecettes = $this->getDoctrine()->getRepository(Publication::class)->lastXRecette(4);


        return $this->render('recette/show.html.twig', [
            'publication' => $publication,
            'lastRecettes' => $lastRecettes,
            
        ]);
    }
}
