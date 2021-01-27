<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Manager\PublicationManager;
use App\Repository\PublicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request, PublicationManager $publicationManager): Response
    {
        $user = $this->getUser();
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationManager->create($publication, $user);

            return $this->redirectToRoute('accueil');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     * @Security("is_granted( constant('\\App\\Security\\Voter\\PublicationVoter::PUBLICATION_EDIT'), publication)")
     */
    public function edit(Request $request, Publication $publication, PublicationManager $publicationManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication, [
            'recette' => Publication::TYPE_FORM_EDIT_PUBLICATION,
            'publication' => $publication
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationManager->updated($publication);

            return $this->redirectToRoute('accueil');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="publication_delete", methods={"GET", "DELETE"})
     * @Security("is_granted( constant('\\App\\Security\\Voter\\PublicationVoter::PUBLICATION_DELETE'), publication)")
     */
    public function delete(Request $request, Publication $publication, PublicationManager $publicationManager): Response
    {
        $publicationManager->delete($publication);

        return $this->redirectToRoute('accueil');
    } 
}
