<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Document;
use App\Entity\Publication;
use App\Entity\User;
use App\Form\PublicationType;
use App\Manager\CommentaireManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Manager\PublicationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AccueilController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="accueil")
     */
    public function index(Request $request, PublicationManager $publicationManager): Response
    {
        $user = $this->getUser() ?? null;

        // Création Recettes
        $recettes = new Publication();

        // Form publication
        $formPublication = $this->createForm(PublicationType::class, $recettes, [
            'recette' => Publication::TYPE_FORM_CREATE_PUBLICATION,
        ]);
        $formPublication->handleRequest($request);

        if ($formPublication->isSubmitted() && $formPublication->isValid()) {
            $recettes->setType(false);
            $publicationManager->create($recettes, $user);

            return $this->redirectToRoute('accueil');
        }

        // Form Recette
        $formRecette = $this->createForm(PublicationType::class, $recettes, [
            'recette' => Publication::TYPE_FORM_CREATED_RECETTE,
        ]);
        $formRecette->handleRequest($request);

        if ($formRecette->isSubmitted() && $formRecette->isValid()) {
            $recettes->setType(true);
            $publicationManager->create($recettes, $user);

            return $this->redirectToRoute('accueil');
        }

        return $this->render('accueil/index.html.twig', [
            'formPublication' => $formPublication->createView(),
            'formRecette' => $formRecette->createView(),
            'publications' => $publicationManager->allPublication(),
            'recettes' => $publicationManager->allRecette(),
            'lastRecettes' => $publicationManager->lastXRecette(),

        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/commentaire_pub", name="commentaire_pub", methods={"GET","POST"})
     */
    public function Commentaire(Request $request, CommentaireManager $commentaireManager): Response
    {
        $user = $this->getUser();
        $commentaire = new Commentaire();

        $commenter = $request->get('comment');
        $idPublication = $request->get('idPublication');
        $commentaire->setContenu($commenter);

        $commentaireManager->create($commentaire, $user, $idPublication);

        return $this->redirectToRoute('accueil');
    }

     /**
      * @IsGranted("ROLE_USER")
     * @Route("/document", name="document")
     */
    public function document()
    {
        // pour lister les documents
        $document = $this->getDoctrine()->getRepository(Document::class)->findBy(
            [],
            ['created_at' => 'desc']
        );
        return $this->render('accueil/document.html.twig', [
            'document' => $document,
        ]);
    }

     /**
      * @IsGranted("ROLE_USER")
     * @Route("/faq", name="faq")
     */
    public function faq(PublicationManager $publicationManager)
    {

        return $this->render('accueil/faq.html.twig', [
            'lastRecettes' => $publicationManager->lastXRecette(),
            'recettes' => $publicationManager->allRecette(),
        ]);
    }

    /**
     * Affiche toute les recettes.
     * @return Response
     */
    public function allRecipes(): Response
    {
        $recipes = $this->getDoctrine()->getRepository(Publication::class)->findBy(
            ['type' => true],
            ['created_at' => 'desc']
        );

        return $this->render('_right_panel.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}


