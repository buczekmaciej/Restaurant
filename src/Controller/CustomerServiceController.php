<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Meals;
use App\Entity\Ingredients;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IngredientsRepository;
use App\Repository\MealsRepository;

class CustomerServiceController extends AbstractController
{
    /**
     * @Route("/employee/logout", name="logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('login', []);
    }

    /**
     * @Route("/employee", name="eHomepage")
     */
    public function eHomepage()
    {
        return $this->render('customer_service/homepage.html.twig', []);
    }

    /**
     * @Route("/employee/meals", name="eMeals")
     */
    public function eMeals(MealsRepository $mR)
    {
        $meals=$mR->findBy(array(),array('Type'=>'ASC'));
        return $this->render('customer_service/meals.html.twig', [
            'meals'=>$meals
        ]);
    }

    /**
     * @Route("/employee/m/new", name="newMeal")
     */
    public function newMeal(EntityManagerInterface $em, Request $request, MealsRepository $mR)
    {
        $new=$this->createFormBuilder()
        ->add('Name', TextType::class,['attr'=>['placeholder'=>'Meal name']])
        ->add('Price', TextType::class, ['attr'=>['placeholder'=>'Meal price']])
        ->add('Type', TextType::class, ['attr'=>['placeholder'=>'Meal type']])
        ->add('Ingr', EntityType::class,[
            'class'=>Ingredients::class,
            'expanded'=>true,
            'multiple'=>true,
            'choice_label'=>'Name'
        ])
        ->add('Insert', SubmitType::class)
        ->getForm();

        $new->handleRequest($request);

        if($new->isSubmitted() && $new->isValid())
        {
            $data=$new->getData();
            
            if(!$mR->findBy(['Name'=>$data['Name']]))
            {
                $meal=new Meals();
                $meal->setName($data['Name']);
                $meal->setPrice($data['Price']);
                $meal->setType($data['Type']);
                foreach($data['Ingr'] as $ing)
                {
                    $meal->addIngredient($ing);
                }

                $em->persist($meal);
                $em->flush();

                $this->addFlash('success', 'Meal has been added');

                return $this->redirectToRoute('eMeals', []);
            }
            else
            {
                $this->addFlash('danger', 'This meal is already in database');
            }
        }

        return $this->render('customer_service/newMeal.html.twig', [
            'new'=>$new->createView()
        ]);
    }

    /**
     * @Route("/employee/{id}/remove", name="removeMeal")
     */
    public function removeMeal(EntityManagerInterface $em, $id, MealsRepository $mR)
    {
        $meal=$mR->findBy(['id'=>$id])[0];
        $em->remove($meal);
        $em->flush();

        $this->addFlash('primary', 'Meal has been removed');
        return $this->redirectToRoute('eMeals', []);
    }

    /**
     * @Route("/employee/{id}/edit", name="editMeal")
     */
    public function editMeal($id, MealsRepository $mR, EntityManagerInterface $em, Request $request)
    {
        $meal=$mR->findBy(['id'=>$id])[0];

        $edit=$this->createFormBuilder()
        ->add('Name',TextType::class, [
            'attr'=>['placeholder'=>'Meal name', 'value'=>$meal->getName()]
        ])
        ->add('Price',NumberType::class, [
            'attr'=>['placeholder'=>'Meal price', 'value'=>$meal->getPrice()]
        ])
        ->add('Type',TextType::class, [
            'attr'=>['placeholder'=>'Meal type', 'value'=>$meal->getType()]
        ])
        ->add('Ingredients',EntityType::class, [
            'class'=>Ingredients::class,
            'choice_label'=>'Name',
            'expanded'=>true,
            'multiple'=>true
        ])
        ->add('Submit',SubmitType::class)
        ->getForm();

        $edit->handleRequest($request);
        if($edit->isSubmitted() && $edit->isValid())
        {
            $data=$edit->getData();
            $meal->setName($data['Name']);
            $meal->setPrice($data['Price']);
            $meal->setType($data['Type']);
            $meal->clearIngr();
            foreach($data['Ingredients'] as $ing)
            {
                $meal->addIngredient($ing);
            }

            $em->flush();
            $this->addFlash('success', 'Meal has been edited');
            return $this->redirectToRoute('eMeals', []);
        }

        return $this->render('customer_service/editMeal.html.twig', [
            'id'=>$id,
            'edit'=>$edit->createView(),
            'meal'=>$meal
        ]);
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
    public function newOrder(EntityManagerInterface $em, Request $request)
    {
        return $this->render('customer_service/newOrder.html.twig', []);
    }

    /**
     * @Route("/employee/order/{id}", name="removeOrder")
     */
    public function removeOrder(EntityManagerInterface $em)
    {
        return $this->redirectToRoute('eOrders', []);
    }

    /**
     * @Route("/employee/ingredients", name="ingredients")
     */
    public function ingredients(IngredientsRepository $iR)
    {
        $ings=$iR->findBy(array(),array('Name'=>'ASC'));
        return $this->render('customer_service/ingredients.html.twig', [
            'ings'=>$ings
        ]);
    }

    /**
     * @Route("/employee/i/new", name="newIngredients")
     */
    public function newIngredients(EntityManagerInterface $em, Request $request, IngredientsRepository $iR)
    {
        $new=$this->createFormBuilder()
        ->add('Name', TextType::class,['attr'=>['placeholder'=>'Ingredient name']])
        ->add('Insert', SubmitType::class)
        ->getForm();

        $new->handleRequest($request);

        if($new->isSubmitted() && $new->isValid())
        {
            $name=$new->getData()['Name'];

            if(!$iR->findBy(['Name'=>$name]))
            {
                $ingerd=new Ingredients();
                $ingerd->setName($name);

                $em->persist($ingerd);
                $em->flush();

                $this->addFlash('success', 'Ingredient has been added');
                
                return $this->redirectToRoute('ingredients', []);
            }
            else
            {
                $this->addFlash('danger', 'This ingredient is already in database');
            }
        }

        return $this->render('customer_service/newIngr.html.twig', [
            'new'=>$new->createView()
        ]);
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
    public function newEmployee(EntityManagerInterface $em, Request $request)
    {
        return $this->render('owner/newEmployee.html.twig', []);
    }

    /**
     * @Route("/owner/employee/{id}", name="removeEmployee")
     */
    public function removeEmployee(EntityManagerInterface $em)
    {
        return $this->redirectToRoute('employees', []);
    }
}
