<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('app/homepage.html.twig', []);
    }

    /**
     * @Route("/menu", name="menu")
     */
    public function menu(\App\Repository\MealsRepository $mr)
    {
        dump($mr->findAll(), $mr->getSortedMeals());

        return $this->render('app/menu.html.twig', []);
    }
}
