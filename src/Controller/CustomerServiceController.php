<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerServiceController extends AbstractController
{
    /**
     * @Route("/customer/service", name="customer_service")
     */
    public function index()
    {
        return $this->render('customer_service/index.html.twig', [
            'controller_name' => 'CustomerServiceController',
        ]);
    }
}
