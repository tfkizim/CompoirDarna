<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use RestaurantBundle\Entity\State;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StateController extends Controller
{
    /**
     * @Route("/state/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $color = $request->get("color");
        $flashed = $request->get("flashed");
        $function = $request->get("function");


        if(!$state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByName($name)){
	        $state=new State();
            $state->setName($name);
            $state->setColor($color);
            $state->setFlashed($flashed);
            $state->setFunction($function);
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($state);
	        $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/state/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneById($id);
        if($state){
            $em=$this->getDoctrine()->getManager();
            $em->remove($state);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/state/edit_xhr/{id}")
     */
    public function editXhrAction(Request $request, $id){
        $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneById($id);
        if($state){
            $name = $request->get("name");
            $color = $request->get("color");
            $flashed = $request->get("flashed");
            $function = $request->get("function");
            $state->setName($name);
            $state->setColor($color);
            $state->setFlashed($flashed);
            $state->setFunction($function);
            $em=$this->getDoctrine()->getManager();
            $em->persist($state);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
}
