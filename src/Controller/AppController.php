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
use App\Entity\Orders;
use App\Repository\OrdersRepository;
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
        // Get unique types of meals
        $types=$mR->findTypes();

        $meals=array();
        foreach($types as $type)
        {   
            // For each type get all avalaible meals
            $meals[]=$mR->findBy(['Type'=>$type]);
        }

        return $this->render('app/meals.html.twig', [
            'types'=>$types,
            'meals'=>$meals
        ]);
    }

    /**
     * @Route("/make-order", name="order")
     */
    public function order(EntityManagerInterface $em, Request $request, SessionInterface $session)
    {
        // Take delivery address
        $order=$this->createFormBuilder()
        ->add('Address', TextType::class,['attr'=>['placeholder'=>'Insert delivery address']])
        ->add('Proceed', SubmitType::class)
        ->getForm();

        $order->handleRequest($request);

        if($order->isSubmitted() && $order->isValid())
        {
            // Put address to session
            $address=$order->getData()['Address'];
            $session->set('address', $address);

            // Redirect to picking meal after saving address to session
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
     * @Route("/order/pick/json", name="jsonMeal", methods={"GET"})
     */
    public function jsonMeal(MealsRepository $mR)
    {
        // Get price and name of all meals and encode data into json
        $meals=$mR->findMeals();
        $meals=json_encode($meals);

        // Return json to get it in javascript
        return $this->json([$meals]);
    }

    /**
     * @Route("/order/process/{data}", name="process")
     */
    public function process($data, SessionInterface $session)
    {
        if ($data != null) { // Check if data is passed in url
            // Get each object from passed url
            $data=explode('[', $data);
            $obj=array();
            foreach($data as $d)
            {
                if($d != null)
                {
                    $obj[]=str_replace(']','',$d); // Remove closing bracket
                }
            }
            $data=array();
            foreach ($obj as $r) {
                $data[]=str_replace('"',"",$r); // Remove quote chars
            }
            $result=array();
            foreach($data as $d)
            {
                $result[]=explode(",",$d); // Get single object
            }
            $session->set('list', $result); // Put objects into session
            
            return $this->redirectToRoute('summary', []);
        } else {
            return $this->redirectToRoute('pickMeal', []);
        }
        
    }

    /**
     * @Route("/order/summary", name="summary")
     */
    public function summary(SessionInterface $session, Request $request)
    {
        // Get address and order
        $address=$session->get('address');
        $orderList=$session->get('list');

        // Make sure address and order list is not empty
        if(!$address)
        {
            return $this->redirectToRoute('order', []);
        }
        if(!$orderList)
        {
            return $this->redirectToRoute('pickMeal', []);
        }

        $total = 0;

        foreach($orderList as $ol)
        {
            $total+=$ol[3]; // Sum total price for whole order
        }

        return $this->render('app/summary.html.twig', [
            'location'=>$address,
            'meals'=>$orderList,
            'total'=>$total
        ]);
    }

    /**
     * @Route("/order/proceed", name="proceed")
     */
    public function proceed(SessionInterface $session, EntityManagerInterface $em)
    {
        // Get address and order
        $address=$session->get('address');
        $orderList=$session->get('list');

        if($address && $orderList) // If both are not empty create order
        {
            // Make new order object
            $order=new Orders();
            $order->setCreateAt(new \DateTime());
            $order->setAddress($address);
            $order->setOrderList($orderList);
            $order->setStatus('Ordered');

            // Put just made object in database
            $em->persist($order);
            $em->flush();

            // Get rid of address and order list
            $session->remove('address');
            $session->remove('list');

            // Generate link to order monitor
            $link = $this->redirectToRoute('monitor',['id'=>$order->getId()]);

            // Redirect to homepage and display link to monitor for just made order
            $this->addFlash('success', sprintf('Your order has been submitted. You can check it <a href="%s">here</a>', $link));
            return $this->redirectToRoute('homepage', []);
        }
    }

    /**
     * @Route("/check-order", name="checkOrder")
     * @Route("/order/{id}", name="monitor")
     */
    public function monitor(OrdersRepository $oR, Request $request)
    {
        $id = $request->get('id'); // Check which url has been used

        if ($id) { // If second (containing id) consider if let see monitor
            if (intval($id)) { // If id is a number pass
                $order=$oR->checkOrder($id)[0]; // Get order

                return $this->render('app/monitor.html.twig', [
                    'order'=>$order
                ]);
            } else { // If is not number back to first url
                return $this->redirectToRoute('checkOrder', []);
            }
            
        } else { // If first url ask for order id
            // Get id from user form
            $req = $this->createFormBuilder()
            ->add('id', TextType::class, ['attr'=>['placeholder'=>'Order id']])
            ->add('Check', SubmitType::class)
            ->getForm();

            $req->handleRequest($request);
            if($req->isSubmitted() && $req->isValid())
            {
                $id = $req->getData()['id']; // Get id
                
                // Direct to second url with proivded id to verify
                return $this->redirectToRoute('monitor', ['id'=>$id]);
            }

            return $this->render('app/monit-req.html.twig', [
                'req'=>$req->createView()
            ]);
        }
        
    }
}
