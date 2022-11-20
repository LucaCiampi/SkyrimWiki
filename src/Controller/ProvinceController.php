<?php

namespace App\Controller;

use App\Entity\Province;
use App\Entity\User;
use App\Form\ProvinceFormType;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProvinceController extends AbstractController
{
    /**
     * Shows all the available provinces
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $provinces = $doctrine->getRepository(Province::class)->findAll();

        return $this->render('pages/provinces/all.html.twig', array(
            'provinces' => $provinces
        ));
    }

    /**
     * Shows a single province
     */
    public function show(ManagerRegistry $doctrine, String $slug): Response
    {
        $province = $doctrine->getRepository(Province::class)->findOneBy(['name' => $slug]);
        $author = $doctrine->getRepository(User::class)->find($province->getAuthor());

        if (!$province) {
            return $this->render('pages/404.html.twig');
        }

        return $this->render('pages/provinces/single.html.twig', array(
            'province' => $province,
            'author' => $author,
        ));
    }

    /**
     * Creates a new province
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $province = new Province();
        $province->setCreatedAt(new \DateTimeImmutable());
        $province->setModifiedAt(new \DateTimeImmutable());
        $province->setAuthor($this->getUser());
        $form = $this->createForm(ProvinceFormType::class, $province);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($province);
            $entityManager->flush();

            return $this->redirectToRoute('app_province_index');
        }

        return $this->render('pages/provinces/new.html.twig', [
            'province_form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing province
     */
    public function edit(Request $request, ManagerRegistry $doctrine, String $slug): Response
    {
        $province = $doctrine->getRepository(Province::class)->findOneBy(['name' => $slug]);

        if ($province->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $province->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(ProvinceFormType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($province);
            $entityManager->flush();

            $this->addFlash('message', 'Province modifiée avec succès');
            return $this->redirectToRoute('app_province_index');
        }

        return $this->render('pages/provinces/edit.html.twig', [
            'province_form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a province
     */
    public function delete(ManagerRegistry $doctrine, String $slug): Response
    {
        $province = $doctrine->getRepository(Province::class)->findOneBy(['name' => $slug]);

        if ($province->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($province);
        $entityManager->flush();

        $this->addFlash('message', 'Province supprimé avec succès');
        return $this->redirectToRoute('app_province_index');
    }
}
