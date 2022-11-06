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

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/races/new.html.twig', [
            'new_race_form' => $form->createView(),
        ]);
    }
}
