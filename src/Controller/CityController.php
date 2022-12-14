<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\User;
use App\Form\CityFormType;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CityController extends AbstractController
{
    /**
     * Shows all the available cities
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $cities = $doctrine->getRepository(City::class)->findAll();

        return $this->render('pages/cities/all.html.twig', array(
            'cities' => $cities
        ));
    }
    
    /**
     * Shows a single city
     */
    public function show(ManagerRegistry $doctrine, String $slug): Response
    {
        $city = $doctrine->getRepository(City::class)->findOneBy(['name' => $slug]);
        $author = $doctrine->getRepository(User::class)->find($city->getAuthor());

        if (!$city) {
            return $this->render('pages/404.html.twig');
        }

        return $this->render('pages/cities/single.html.twig', array(
            'city' => $city,
            'author' => $author,
        ));
    }

    /**
     * Creates a new city
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $city = new City();
        $city->setCreatedAt(new \DateTimeImmutable());
        $city->setModifiedAt(new \DateTimeImmutable());
        $city->setAuthor($this->getUser());
        $form = $this->createForm(CityFormType::class, $city);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('app_city_index');
        }

        return $this->render('pages/cities/new.html.twig', [
            'city_form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing city
     */
    public function edit(Request $request, ManagerRegistry $doctrine, String $slug): Response
    {
        $city = $doctrine->getRepository(City::class)->findOneBy(['name' => $slug]);
        
        if ($city->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $city->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(CityFormType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            $this->addFlash('message', 'City modifi??e avec succ??s');
            return $this->redirectToRoute('app_city_index');
        }
        
        return $this->render('pages/cities/edit.html.twig', [
            'city_form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a city
     */
    public function delete(ManagerRegistry $doctrine, String $slug): Response
    {
        $city = $doctrine->getRepository(City::class)->findOneBy(['name' => $slug]);

        if ($city->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }        

        $entityManager = $doctrine->getManager();
        $entityManager->remove($city);
        $entityManager->flush();

        $this->addFlash('message', 'City successfully deleted');
        return $this->redirectToRoute('app_city_index');
    }
}
