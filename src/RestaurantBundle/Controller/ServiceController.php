<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Service;
use RestaurantBundle\Entity\Config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceController extends Controller
{
    /**
     * @Route("/service/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $openhour = $request->get("openhour");
        $closehour = $request->get("closehour");
        $interval_value = $request->get("interval");
        $openhour_value=$this->container->get('get_service')->timeToSeconds($openhour);
        $closehour_value=$this->container->get('get_service')->timeToSeconds($closehour);
        
        if(!$service=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneByName($name)){
	        $service=new Service();
            $service->setName($name);
            $service->setDe($openhour_value);
            $service->setOrdre(0);
            $service->setA($closehour_value);
	        $service->setIntervale($interval_value);
            if($openhours=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("ARRAYOPENINGHOURS")){
                if(!empty($openhours->getValue())){
                    $dayspost=(array) json_decode($openhours->getValue());
                    foreach($dayspost as $day=>$post){
                        $dayspost[$day]->OPENHOUR=$openhour;
                        $dayspost[$day]->CLOSEHOUR=$closehour;
                        $dayspost[$day]->INTERVAL=$interval_value;
                    }
                    $dayspost=json_encode($dayspost);
                    $service->setValeur($dayspost);
                }
            }
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($service);
	        $em->flush();
            $val=$service->getValeur();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","valeur"=>$val));
        }else{
            $val=$service->getValeur();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist","valeur"=>$val));
        }
    }
    /**
     * @Route("/service/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $service=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($id);
        if($service){
            $em=$this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
}
