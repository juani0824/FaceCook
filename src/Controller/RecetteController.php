<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\User;
use App\Entity\Publication;
use App\Manager\PublicationManager;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            'recettes' => $publicationManager->allRecette(),
            'lastRecettes' => $publicationManager->lastXRecette(),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="recette_detail", requirements={"id":"\d+"}, methods={"GET"})
     */
    public function detail(Publication $publication, PublicationManager $publicationManager): Response
    {
        // recuperer les 3 dernier recettes
        $lastRecettes = $this->getDoctrine()->getRepository(Publication::class)->lastXRecette(4);


        return $this->render('recette/show.html.twig', [
            'publication' => $publication,
            'lastRecettes' => $lastRecettes,
            'recettes' => $publicationManager->allRecette(),

            
        ]);
    }

    /**
     * @Route("/{id}/favorite", name="recette_favorite", methods={"POST"})
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
