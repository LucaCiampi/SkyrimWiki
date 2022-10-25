<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class RaceController extends AbstractController
{
    /**
     * Shows all the available races
     */
    public function index(): Response
    {
        return $this->render('pages/races/all.html.twig');
    }
    
    /**
     * Shows a single race
     */
    public function show(): Response
    {
        return $this->render('pages/races/single.html.twig');
    }
}
