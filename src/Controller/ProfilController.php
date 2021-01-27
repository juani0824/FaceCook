<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\PublicationType;
use App\Form\RegistrationFormType;
use App\Manager\PublicationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProfilController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/profil/{id}", name="profil", methods={"GET","POST"})
     * 
     */
    public function index(User $user, PublicationManager $publicationManager): Response
    {
        // historique des les publications
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('App:Publication')->findBy(
            array('users' => $user->getId()),
            array('created_at' => 'Desc')
        );
        
        $lastPRecette = $this->getDoctrine()->getRepository(Publication::class)->lastXRecette(9);
      
        return $this->render('profil/index.html.twig', [
          
            'publications' => $publications,
            'mesRecettes' => $publicationManager->getRecetteByUser($user),
            'recettes' => $publicationManager->allRecette(),
            
            'user' => $user,
            //'lastRecettes' => $lastRecettes,
            'lastRecettes' => $publicationManager->lastXRecette(),
            'lastPRecettes' => $lastPRecette,
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/commentaire_profil", name="commentaire_profil", methods={"GET","POST"})
     */
    public function Commentaire(Request $request): Response
    {
        $commentaire = new Commentaire();

        $commenter = $request->get('commenter');
        $postComment = $request->get('postComment');
        $entityManager = $this->getDoctrine()->getManager();

        $commentaire->setContenu($commenter);
        $commentaire->setUsers($this->getUser());

        $commentaire->setPublications($entityManager->getReference("App:Publication", $postComment));
        $commentaire->setCreatedAt(new \DateTime('now'));
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('accueil'); // rediriger à la pagina profil
    }
}
