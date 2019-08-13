<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerServiceController extends AbstractController
{
    /**
     * @Route("/employee/login", name="login")
     */
    public function login()
    {
        return $this->render('customer_service/login.html.twig', []);
    }

    /**
     * @Route("/employee/logout", name="logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('login', []);
    }

    /**
     * @Route("/employee/meals", name="eMeals")
     */
    public function eMeals()
    {
        return $this->render('customer_service/meals.html.twig', []);
    }

    /**
     * @Route("/employe/m/new", name="newMeal")
     */
    public function newMeal()
    {
        return $this->render('customer_service/newMeal.html.twig', []);
    }

    /**
     * @Route("/employee/neal/{id}", name="removeMeal")
     */
    public function removeMeal()
    {
        return $this->redirectToRoute('eMeals', []);
    }

    /**
     * @Route("/employee/orders", name="eOrders")
     */
    public function eOrders()
    {
        return $this->render('customer_service/orders.html.twig', []);
    }
    
    /**
     * @Route("/employee/o/new", name="newOrder")
     */
    public function newOrder()
    {
        return $this->render('customer_service/newOrder.html.twig', []);
    }

    /**
     * @Route("/employee/order/{id}", name="removeOrder")
     */
    public function removeOrder()
    {
        return $this->redirectToRoute('eOrders', []);
    }

    /**
     * @Route("/employee/ingredients", name="ingredients")
     */
    public function ingredients()
    {
        return $this->render('customer_service/ingredients.html.twig', []);
    }

    /**
     * @Route("/employee/i/new", name="newIngredients")
     */
    public function newIngredients()
    {
        return $this->render('customer_service/newIngr.html.twig', []);
    }

    /**
     * @Route("/owner/employees", name="employees")
     */
    public function employees()
    {
        return $this->render('owner/employees.html.twig', []);
    }
    
    /**
     * @Route("/owner/e/new", name="newEmployee")
     */
    public function newEmployee()
    {
        return $this->render('owner/newEmployee.html.twig', []);
    }

    /**
     * @Route("/owner/employee/{id}", name="removeEmployee")
     */
    public function removeEmployee()
    {
        return $this->redirectToRoute('employees', []);
    }
}
