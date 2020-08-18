<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->render('app/menu.html.twig', [
            'menu' => $mr->getSortedMeals()
        ]);
    }

    /**
     * @Route("/order", name="order")
     */
    public function order(Request $request)
    {
        return $this->render('app/order.html.twig', []);
    }

    /**
     * @Route("/order/pick", name="orderPick")
     */
    public function orderPick(\App\Repository\MealsRepository $mr)
    {
        return $this->render('app/pick.html.twig', [
            'meals' => $mr->getOrderMeals()
        ]);
    }

    /**
     * @Route("/order/summary", name="orderSummary")
     */
    public function orderSummary()
    {
        return $this->render('app/summary.html.twig', []);
    }

    /**
     * @Route("/order/place", name="orderPlace", methods={"POST"})
     */
    public function placeOrder(Request $request, \Doctrine\ORM\EntityManagerInterface $em)
    {
        $data = json_decode($request->request->get('order', true));
        $temp = [];
        foreach ($data as $key => $d) {
            $temp[$key] = $d;
        }
        unset($data);

        try {
            $order = new \App\Entity\Orders;
            $order->setCreateAt(new \DateTime());
            $order->setAddress($temp['address']);
            $order->setOrderList($temp['list']);
            $order->setStatus('Preparing...');

            $em->persist($order);
            $em->flush();

            return new Response($order->getId());
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            return new Response($e->getMessage());
        }
    }

    /**
     * @Route("/order-monitor", name="orderMonitor")
     */
    public function orderMonitor(Request $request, \App\Repository\OrdersRepository $or)
    {
        return $this->render('app/monitor.html.twig', [
            'status' => $request->query->get('id') ? $or->findOneBy(['id' => intval($request->query->get('id'))]) : null
        ]);
    }
}
