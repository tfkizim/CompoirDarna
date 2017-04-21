<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotificationController extends Controller
{
    /**
     * @Route("/notification/all")
     */
    public function indexAction()
    {
        $notiftoday=$this->getDoctrine()->getRepository("RestaurantBundle:Notification")->Today();
        $notifyesterday=$this->getDoctrine()->getRepository("RestaurantBundle:Notification")->Yesterday();
        $notifthismonth=$this->getDoctrine()->getRepository("RestaurantBundle:Notification")->ThisMonth();

        return $this->render('RestaurantBundle:notification:index.html.twig',compact('notiftoday','notifyesterday','notifthismonth'));
    }
    /**
     * @Route("/notification/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $notification=$this->getDoctrine()->getRepository("RestaurantBundle:Notification")->findOneById($id);
        if($notification){
            $em=$this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
}
