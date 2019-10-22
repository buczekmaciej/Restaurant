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
     * @Route("/make-order", name="order")
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
     * @Route("/order/pick/json", name="jsonMeal", methods={"POST"})
     */
    public function jsonMeal(MealsRepository $mR)
    {
        $meals=$mR->findMeals();
        $meals=json_encode($meals);
        return $this->json([$meals]);
    }

    /**
     * @Route("/order/process/{data}", name="process")
     */
    public function process($data, SessionInterface $session)
    {
        if ($data != null) {
            $data=explode('[', $data);
            $obj=array();
            foreach($data as $d)
            {
                if($d != null)
                {
                    $obj[]=str_replace(']','',$d);
                }
            }
            $data=array();
            foreach ($obj as $r) {
                $data[]=str_replace('"',"",$r);
            }
            $result=array();
            foreach($data as $d)
            {
                $result[]=explode(",",$d);
            }
            $session->set('list', $result);
            
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
        $address=$session->get('address');
        $orderList=$session->get('list');

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
            $total+=$ol[3];
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
        $address=$session->get('address');
        $orderList=$session->get('list');

        if($address && $orderList)
        {
            $order=new Orders();
            $order->setCreateAt(new \DateTime());
            $order->setAddress($address);
            $order->setOrderList($orderList);
            $order->setStatus('Ordered');

            $em->persist($order);
            $em->flush();


            $session->remove('address');
            $session->remove('list');

            $link = $this->generateUrl('monitor',['id'=>$order->getId()]);

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
        $id = $request->get('id');

        if ($id) {
            if (intval($id)) {
                $order=$oR->checkOrder($id)[0];

                return $this->render('app/monitor.html.twig', [
                    'order'=>$order
                ]);
            } else {
                return $this->redirectToRoute('checkOrder', []);
            }
            
        } else {
            $req = $this->createFormBuilder()
            ->add('id', TextType::class, ['attr'=>['placeholder'=>'Order id']])
            ->add('Check', SubmitType::class)
            ->getForm();

            $req->handleRequest($request);
            if($req->isSubmitted() && $req->isValid())
            {
                $id = $req->getData()['id'];
                
                return $this->redirectToRoute('monitor', ['id'=>$id]);
            }

            return $this->render('app/monit-req.html.twig', [
                'req'=>$req->createView()
            ]);
        }
        
    }
}
