<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Commentaire;
use App\Entity\Favorite;
use App\Entity\Like;
use App\Entity\User;
use App\Manager\PublicationManager;
use App\Repository\FavoriteRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        // Lister all mes Favorites
        $favorites = $em->getRepository('App:Favorite')->findBy(
            array('user' => $user->getId())
           
        ); 

        // last 9 favorites
        
        
        

        return $this->render('profil/index.html.twig', [

            'publications' => $publications,
            'mesRecettes' => $publicationManager->getRecetteByUser($user),
            'mesFavoris' => $favorites,
            'recettes' => $publicationManager->allRecette(),
            'user' => $user,
            'lastRecettes' => $publicationManager->lastXRecette(),
            'lastPRecettes' => $publicationManager->lastPRecette($user, 6),
               

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
        $user = $this->getDoctrine()->getRepository('App:User')->find($this->getUser());
        $commentaire->setPublications($entityManager->getReference("App:Publication", $postComment));
        $commentaire->setCreatedAt(new \DateTime('now'));
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('profil', ['id' => $user->getId()]); // rediriger à la pagina profil
    }


    /**
     * @Route("/{id}/like", name="profil_like", methods={"POST"})
     */
    public function like(Publication $publication, LikeRepository $likeRepository, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $this->getUser();

        $content = '+';
        $statusCode = 200;
        if (null === $like = $likeRepository->findPublicationLikedBy($publication, $user)) {
            $like = new Like();
            $like->setUser($user)
                ->setPublication($publication);

            $entityManager->persist($like);
        } else {
            $entityManager->remove($like);
            $content = '-';
        }

        $entityManager->flush();

        return $this->json($content, $statusCode);
    }


    /**
     * @Route("/{id}/favorite", name="profil_favorite", methods={"POST"})
     */
    public function favorite(Publication $publication, FavoriteRepository $favoriteRepository, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $this->getUser();

        $content = '+';
        $statusCode = 200;
        if (null === $favorite = $favoriteRepository->findFavoritePublication($publication, $user)) {
            $favorite = new Favorite();
            $favorite->setUser($user)
                ->setPublication($publication);

            $entityManager->persist($favorite);
        } else {
            $entityManager->remove($favorite);
            $content = '-';
        }

        $entityManager->flush();

        return $this->json($content, $statusCode);
    }
}
