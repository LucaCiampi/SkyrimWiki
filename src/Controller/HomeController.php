<?php

namespace App\Controller;

use App\Entity\Province;
use App\Entity\Follower;
use App\Entity\City;
use App\Entity\Race;
use App\Entity\Skill;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $latest_provinces = $doctrine->getRepository(Province::class)->findBy(array(), array('id' => 'DESC'), 3, 0);
        $latest_followers = $doctrine->getRepository(Follower::class)->findBy(array(), array('id' => 'DESC'), 3, 0);
        $latest_cities = $doctrine->getRepository(City::class)->findBy(array(), array('id' => 'DESC'), 3, 0);
        $latest_races = $doctrine->getRepository(Race::class)->findBy(array(), array('id' => 'DESC'), 3, 0);
        $latest_skills = $doctrine->getRepository(Skill::class)->findBy(array(), array('id' => 'DESC'), 3, 0);

        return $this->render(
            'pages/home.html.twig',
            array(
                'last_provinces_articles' => $latest_provinces,
                'last_followers_articles' => $latest_followers,
                'last_cities_articles' => $latest_cities,
                'last_races_articles' => $latest_races,
                'last_skills_articles' => $latest_skills
            )
        );
    }
}
