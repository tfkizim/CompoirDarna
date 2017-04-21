<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Occasion;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OccasionController extends Controller
{
    /**
     * @Route("/occasion/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $icon = $request->get("icon");
        $color = $request->get("color");


        if(!$occasion=$this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->findOneByName($name)){
	        $occasion=new Occasion();
            $occasion->setName($name);
            $occasion->setIcon($icon);
            $occasion->setColor($color);
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($occasion);
	        $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/occasion/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $occasion=$this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->findOneById($id);
        if($occasion){
            $em=$this->getDoctrine()->getManager();
            $em->remove($occasion);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/occasion/edit_xhr/{id}")
     */
    public function editXhrAction(Request $request,$id){
        $occasion=$this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->findOneById($id);
        if($occasion){
            $name = $request->get("name");
            $icon = $request->get("icon");
            $icon = $request->get("color");
            if(!empty($name)){
                $occasion->setName($name);
                $occasion->setIcon($icon);
                $occasion->setColor($color);
                $em=$this->getDoctrine()->getManager();
                $em->persist($occasion);
                $em->flush();
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok"));
            }
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
}
