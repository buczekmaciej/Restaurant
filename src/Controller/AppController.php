<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MealsRepository;

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
     * @Route("/meals", name="meals")
     */
    public function meals(MealsRepository $mR)
    {
        $types=$mR->findTypes();

        $meals=array();
        foreach($types as $type)
        {
            $meals[]=$mR->findBy(['Type'=>$type]);
        }

        return $this->render('app/meals.html.twig', [
            'types'=>$types,
            'meals'=>$meals
        ]);
    }

    /**
     * @Route("/order", name="order")
     */
    public function order()
    {
        return $this->render('app/order.html.twig', []);
    }
}
