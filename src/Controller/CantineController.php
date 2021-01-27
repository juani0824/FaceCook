<?php

namespace App\Controller;

use App\Entity\Cantine;
use App\Form\CantineType;
use App\Manager\PublicationManager;
use App\Repository\CantineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/cantine")
 */
class CantineController extends AbstractController
{
    /**     
     * @Route("/", name="cantine_index", methods={"GET"})
     */
    public function index(CantineRepository $cantineRepository, PublicationManager $publicationManager): Response
    {
        
        return $this->render('cantine/index.html.twig', [
            'cantines' => $cantineRepository->findAll(),
            'recettes' => $publicationManager->allRecette(),
            'lastRecettes' => $publicationManager->lastXRecette(),
        ]);
    }

    /**
     * @Route("/new", name="cantine_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cantine = new Cantine();
        $form = $this->createForm(CantineType::class, $cantine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cantine);
            $entityManager->flush();

            return $this->redirectToRoute('cantine_index');
        }

        return $this->render('cantine/new.html.twig', [
            'cantine' => $cantine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cantine_show", methods={"GET"})
     */
    public function show(Cantine $cantine): Response
    {
        return $this->render('cantine/show.html.twig', [
            'cantine' => $cantine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cantine_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cantine $cantine): Response
    {
        $form = $this->createForm(CantineType::class, $cantine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cantine_index');
        }

        return $this->render('cantine/edit.html.twig', [
            'cantine' => $cantine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cantine_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cantine $cantine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cantine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cantine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cantine_index');
    }
}
