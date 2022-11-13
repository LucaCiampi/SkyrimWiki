<?php

namespace App\Controller;

use App\Entity\Follower;
use App\Form\FollowerFormType;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowerController extends AbstractController
{
    /**
     * Shows all the available followers
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $followers = $doctrine->getRepository(Follower::class)->findAll();

        return $this->render('pages/followers/all.html.twig', array(
            'followers' => $followers
        ));
    }
    
    /**
     * Shows a single follower
     */
    public function show(ManagerRegistry $doctrine, String $slug): Response
    {
        $follower = $doctrine->getRepository(Follower::class)->findOneBy(['name' => $slug]);

        if (!$follower) {
            return $this->render('pages/404.html.twig');
        }

        return $this->render('pages/followers/single.html.twig', array(
            'follower' => $follower
        ));
    }

    /**
     * Creates a new follower
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $follower = new Follower();
        $follower->setCreatedAt(new \DateTimeImmutable());
        $follower->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(FollowerFormType::class, $follower);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($follower);
            $entityManager->flush();

            return $this->redirectToRoute('app_follower_index');
        }

        return $this->render('pages/followers/new.html.twig', [
            'follower_form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing follower
     */
    public function edit(Request $request, ManagerRegistry $doctrine, String $slug): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $follower = $doctrine->getRepository(Follower::class)->findOneBy(['name' => $slug]);

        $follower->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(FollowerFormType::class, $follower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($follower);
            $entityManager->flush();

            $this->addFlash('message', 'Follower modifiée avec succès');
            return $this->redirectToRoute('app_follower_index');
        }
        
        return $this->render('pages/followers/edit.html.twig', [
            'follower_form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a follower
     */
    public function delete(ManagerRegistry $doctrine, String $slug): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        
        $follower = $doctrine->getRepository(Follower::class)->findOneBy(['name' => $slug]);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($follower);
        $entityManager->flush();

        $this->addFlash('message', 'Follower supprimé avec succès');
        return $this->redirectToRoute('app_follower_index');
    }
}
