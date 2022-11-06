<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\RaceFormType;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RaceController extends AbstractController
{
    /**
     * Shows all the available races
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $races = $doctrine->getRepository(Race::class)->findAll();

        return $this->render('pages/races/all.html.twig', array(
            'races' => $races
        ));
    }
    
    /**
     * Shows a single race
     */
    public function show(ManagerRegistry $doctrine, String $slug): Response
    {
        $race = $doctrine->getRepository(Race::class)->findOneBy(['name' => $slug]);

        if (!$race) {
            return $this->render('pages/404.html.twig');
        }

        return $this->render('pages/races/single.html.twig', array(
            'race' => $race
        ));
    }

    /**
     * Creates a new race
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $race = new Race();
        $race->setCreatedAt(new \DateTimeImmutable());
        $race->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(RaceFormType::class, $race);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($race);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_index');
        }

        return $this->render('pages/races/new.html.twig', [
            'race_form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing race
     */
    public function edit(Request $request, ManagerRegistry $doctrine, String $slug): Response
    {
        $race = $doctrine->getRepository(Race::class)->findOneBy(['name' => $slug]);

        // if ($post->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
        //     throw $this->createAccessDeniedException();
        // }

        $race->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(RaceFormType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($race);
            $entityManager->flush();

            $this->addFlash('message', 'Race modifiée avec succès');
            return $this->redirectToRoute('app_race_index');
        }
        
        return $this->render('pages/races/edit.html.twig', [
            'race_form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a race
     */
    public function delete(ManagerRegistry $doctrine, String $slug): Response
    {
        $race = $doctrine->getRepository(Race::class)->findOneBy(['name' => $slug]);

        // if ($race->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
        //     throw $this->createAccessDeniedException();
        // }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($race);
        $entityManager->flush();

        $this->addFlash('message', 'Race supprimé avec succès');
        return $this->redirectToRoute('app_race_index');
    }
}
