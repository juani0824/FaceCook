<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Manager\CommentaireManager;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_USER")
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="commentaire_index", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commentaire_new", methods={"GET","POST"})
     */
    public function new(Request $request, CommentaireManager $commentaireManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireManager->create($commentaire);

            return $this->redirectToRoute('commentaire_index');
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }
 
    use \Sideclick\BootstrapModalBundle\Controller\ControllerTrait;
    /**
     * @Route("/{id}/edit", name="commentaire_edit", methods={"GET","POST"})
     * @Security("is_granted( constant('\\App\\Security\\Voter\\CommentaireVoter::COMMENTAIRE_EDIT'), commentaire)")
     */
    public function edit(Request $request, Commentaire $commentaire, CommentaireManager $commentaireManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireManager->updated($commentaire);

            
            return $this->redirectToRouteWithAjaxSupport($request, 'accueil');
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="commentaire_delete", methods={"GET","DELETE"})
     * @Security("is_granted( constant('\\App\\Security\\Voter\\CommentaireVoter::COMMENTAIRE_DELETE'), commentaire)")
     */
    public function delete(Request $request, Commentaire $commentaire, CommentaireManager $commentaireManager): Response
    {
        $commentaireManager->delete($commentaire);

        return $this->redirectToRoute('accueil');
    }

    
}
