<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MealsRepository;
use App\Entity\Meals;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    public function order(EntityManagerInterface $em, Request $request, SessionInterface $session)
    {
        $order=$this->createFormBuilder()
        ->add('Address', TextType::class,['attr'=>['placeholder'=>'Insert delivery address']])
        ->add('Proceed', SubmitType::class)
        ->getForm();

        $order->handleRequest($request);

        if($order->isSubmitted() && $order->isValid())
        {
            $address=$order->getData()['Address'];

            $session->set('address', $address);

            return $this->redirectToRoute('pickMeal', []);
        }

        return $this->render('app/order.html.twig', [
            'order'=>$order->createView()
        ]);
    }
    
    /**
     * @Route("/order/pick", name="pickMeal")
     */
    public function pickMeal()
    {
        return $this->render('app/pick.html.twig', []);
    }

    /**
     * @Route("/order/pick/json", name="jsonMeal")
     */
    public function jsonMeal(MealsRepository $mR)
    {
        $meals=$mR->findMeals();
        $meals=json_encode($meals);
        return $this->json([$meals]);
    }

    /**
     * @Route("/order/summary", name="summary")
     */
    public function summary(SessionInterface $session)
    {
        $address=$session->get('address');

        return $this->render('app/summary.html.twig', []);
    }

    /**
     * @Route("/order/proceed", name="proceed")
     */
    public function proceed()
    {

        return $this->redirectToRoute('homepage', []);
    }
}
