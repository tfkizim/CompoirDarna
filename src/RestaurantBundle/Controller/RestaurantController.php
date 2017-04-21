<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RestaurantController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction($date="",$service=0)
    {
        if(empty($date))
            $date=new \DateTime();
        else
            $date=new \DateTime($date);

        $selectedservice=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($service);
        $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDateService($date,$service);
        $nbrpax=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->CountDateService($date,$service);
        $nbrpax=$nbrpax['nbrpax'];
        $siteopening=array();
        if($siteopening=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("SITEOPENINGHOURS")){
            $siteopening=json_decode($siteopening->getValue());
        }
        $selecteddate=$date;
        $statesfilter=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findBy(array('hideInFilter'=>0),array("orderInFilter"=>"ASC"));
        $services=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findAll();
        return $this->render('RestaurantBundle:index:index.html.twig',compact('books','services','selectedservice','selecteddate','statesfilter','nbrpax'));
    }

    /**
     * @Route("/")
     */
    public function redirectToLoginAction()
    {
        return $this->redirectToRoute("fos_user_security_login");
    }
}
