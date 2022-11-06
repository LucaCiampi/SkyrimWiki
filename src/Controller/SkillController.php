<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillFormType;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends AbstractController
{
    /**
     * Shows all the available skills
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $skills = $doctrine->getRepository(Skill::class)->findAll();

        return $this->render('pages/skills/all.html.twig', array(
            'skills' => $skills
        ));
    }
    
    /**
     * Shows a single skill
     */
    public function show(ManagerRegistry $doctrine, String $slug): Response
    {
        $skill = $doctrine->getRepository(Skill::class)->findOneBy(['name' => $slug]);

        if (!$skill) {
            return $this->render('pages/404.html.twig');
        }

        return $this->render('pages/skills/single.html.twig', array(
            'skill' => $skill
        ));
    }

    /**
     * Creates a new skill
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skill();
        $skill->setCreatedAt(new \DateTimeImmutable());
        $skill->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(SkillFormType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('app_skill_index');
        }

        return $this->render('pages/skills/new.html.twig', [
            'skill_form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing skill
     */
    public function edit(Request $request, ManagerRegistry $doctrine, String $slug): Response
    {
        $skill = $doctrine->getRepository(Skill::class)->findOneBy(['name' => $slug]);

        // if ($post->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
        //     throw $this->createAccessDeniedException();
        // }

        $skill->setModifiedAt(new \DateTimeImmutable());
        $form = $this->createForm(SkillFormType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($skill);
            $entityManager->flush();

            $this->addFlash('message', 'Skill modifiée avec succès');
            return $this->redirectToRoute('app_skill_index');
        }
        
        return $this->render('pages/skills/edit.html.twig', [
            'skill_form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a skill
     */
    public function delete(ManagerRegistry $doctrine, String $slug): Response
    {
        $skill = $doctrine->getRepository(Skill::class)->findOneBy(['name' => $slug]);

        // if ($skill->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
        //     throw $this->createAccessDeniedException();
        // }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($skill);
        $entityManager->flush();

        $this->addFlash('message', 'Skill supprimé avec succès');
        return $this->redirectToRoute('app_skill_index');
    }
}
