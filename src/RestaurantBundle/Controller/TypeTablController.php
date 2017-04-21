<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\TypeTabl;
use RestaurantBundle\Entity\Config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TypeTablController extends Controller
{
    /**
     * @Route("/typetabl/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $class = $request->get("class");
        
        if(!$typetabl=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneByName($name)){
	        $typetabl=new TypeTabl();
            $typetabl->setName($name);
            $typetabl->setClass($class);

	        $em=$this->getDoctrine()->getManager();
	        $em->persist($typetabl);
	        $em->flush();
            
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/typetabl/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $typetabl=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($id);
        if($typetabl){
            $em=$this->getDoctrine()->getManager();
            $em->remove($typetabl);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
}
