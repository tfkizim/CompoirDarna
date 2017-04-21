<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Offer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OfferController extends Controller
{
    /**
     * @Route("/offer/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $icon = $request->get("icon");


        if(!$offer=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->findOneByName($name)){
	        $offer=new Offer();
            $offer->setName($name);
            $offer->setIcon($icon);
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($offer);
	        $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/offer/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $offer=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->findOneById($id);
        if($offer){
            $em=$this->getDoctrine()->getManager();
            $em->remove($offer);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/offer/edit_xhr/{id}")
     */
    public function editXhrAction(Request $request, $id){
        $offer=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->findOneById($id);
        if($offer){
            $name = $request->get("name");
            $icon = $request->get("icon");
            $offer->setName($name);
            $offer->setIcon($icon);
            $em=$this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
}
