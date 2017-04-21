<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Floor;
use RestaurantBundle\Entity\Service;
use RestaurantBundle\Entity\TypeTabl;
//use RestaurantBundle\Entity\Tabl;
use RestaurantBundle\Entity\Config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class FloorController extends Controller
{
    /**
     * @Route("/floor/")
     */
    public function indexAction($id=1,$date="",$service=2)
    {
        if(empty($date))
            $date=new \DateTime();
        else
            $date=new \DateTime($date);
        //Booooks here
        $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDate($date);
        $floors=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findAll();
        $services=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findAll();
        $selectedfloor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($id);
        $typetabls=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findAll();
        $selectedservice=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($service);
        $tabls=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findBy(array('floorId'=>$selectedfloor,'grouptablId'=>null));
        $booktables=array();
        foreach($books as $b){
            foreach($b->getBooktabls() as $bt){
                if($b->getStateId() && $b->getStateId()->getFunction()!="free") $booktables[$bt->getTablId()->getId()][$b->getDateBook()->format("U")]=$b;
            }
        }
        //$grouptabls=$this->getDoctrine()->getRepository("RestaurantBundle:GroupTabl")->findAll();
        if($selectedfloor && $selectedservice){
            return $this->render('RestaurantBundle:floor:index.html.twig',array(
                'tabls'=>$tabls,'floors'=>$floors,'services'=>$services,'selectedfloor'=>$selectedfloor,
                'selectedservice'=>$selectedservice,'typetabls'=>$typetabls,'datetime'=>$date/*,
                'grouptabls'=>$grouptabls*/,'books'=>$books,'booktables'=>$booktables));
        }
    }
    public function plansBooksAction($date){
        if(empty($date))
            $date=new \DateTime();
        else
            $date=new \DateTime($date);
        $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDate($date);
        $booktables=array();
        foreach($books as $b){
            foreach($b->getBooktabls() as $bt){
                if($b->getStateId() && $b->getStateId()->getFunction()!="free"){
                    $booktables[$bt->getTablId()->getId()]=array("table"=>$bt->getTablId()->getId(),"book"=>$b->getId(),"state"=>"md-bg-".$b->getStateId()->getColor());
                }
            }
        }
        $booktables=json_encode($booktables);
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"ok",'booktables'=>$booktables));
    }
    /**
     * @Route("/floor/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $nbrCovert = $request->get("nbr_covert");
        $nbrServer = $request->get("nbr_server");
        
        if(!$floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneByName($name)){
	        $floor=new Floor();
            $floor->setName($name);
            $floor->setNbrCovert($nbrCovert);
            $floor->setNbrServer($nbrServer);
            $floor->setOrdre(0);
            
            
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($floor);
	        $em->flush();
            
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/floor/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($id);
        if($floor){
            $em=$this->getDoctrine()->getManager();
            $em->remove($floor);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
}
