<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Tabl;
use RestaurantBundle\Entity\TablTypeTabl;
use RestaurantBundle\Entity\Config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TablController extends Controller
{
    /**
     * @Route("/tabl/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $nbrChaire = $request->get("nbr_chaire");
        $floorId = $request->get("floor_id");
        $typetablsId = $request->get("typetabl_id");
        $provisoire_id = $request->get("provisoire_id");
        
        $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($floorId);

        if(!$tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneByName($name) && $floor && is_string($provisoire_id)){
	        $tabl=new Tabl();
            $tabl->setName($name);
            $tabl->setNbrChaire($nbrChaire);
            $tabl->setFloorId($floor);

            //$tabl->setTypetablId($typeTabl);
            
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($tabl);
	        $em->flush();
            $classe="";
            $typetablsId=explode(",", $typetablsId);
            foreach($typetablsId as $tti){
                $typetablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($tti);
                if($typetablId){
                    $tablTypeTabl=new TablTypeTabl();
                    $tablTypeTabl->setTypeTablId($typetablId)->setTablId($tabl);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($tablTypeTabl);
                    $em->flush();
                    $classe.=' '.$typetablId->getClass();
                }
            }
            
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","classe"=>$classe,'id'=>$tabl->getId(),'provisoire_id'=>$provisoire_id));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/tabl/select_xhr/{id}")
     */
    public function selectXhrAction($id)
    {
        if($tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($id)){
            $classe="";
            $classeid="";
            $tablTypeTabls=$this->getDoctrine()->getRepository("RestaurantBundle:TablTypeTabl")->findByTablId($tabl->getId());
            if($tablTypeTabls){
                foreach($tablTypeTabls as $tablTypeTabl){
                    $typetablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($tablTypeTabl->getTypeTablId());
                    if($typetablId){
                        $classe.=' '.$typetablId->getClass();
                        $classeid.=','.$typetablId->getId();
                    }
                } 
            }
            $classeid=substr($classeid,1);
            $classe=substr($classe,1);
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","classe"=>$classe,'id'=>$tabl->getId(),'topp'=>$tabl->getTopp(),'leftp'=>$tabl->getLeftp(),'rotation'=>$tabl->getRotation(),'name'=>$tabl->getName(),'nbrChaire'=>$tabl->getNbrChaire(),'classeid'=>$classeid));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/tabl/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($id);
        if($tabl){
            $em=$this->getDoctrine()->getManager();
            $em->remove($tabl);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/tabl/edit_rotation_xhr/{id}")
     */
    public function editRotationXhrAction(Request $request, $id){
        $tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($id);
        if($tabl){
            $rotation = $request->get("rotation");
            $tabl->setRotation($rotation);
            $em=$this->getDoctrine()->getManager();
            $em->persist($tabl);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
    /**
     * @Route("/tabl/edit_drag_xhr/{id}")
     */
    public function editDragXhrAction(Request $request, $id){
        $tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($id);
        if($tabl){
            $topp = $request->get("top");
            $leftp = $request->get("left");
            $tabl->setTopp($topp);
            $tabl->setLeftp($leftp);
            $em=$this->getDoctrine()->getManager();
            $em->persist($tabl);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
    /**
     * @Route("/tabl/edit_xhr/{id}")
     */
    public function editXhrAction(Request $request, $id){
        $tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($id);
        if($tabl){
            $name = $request->get("name");
            $nbrChaire = $request->get("nbr_chaire");
            $floorId = $request->get("floor_id");
            $typetablsId = $request->get("typetabl_id");

            $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($floorId);
            
            $tabl->setName($name);
            $tabl->setNbrChaire($nbrChaire);
            $tabl->setFloorId($floor);

            $em=$this->getDoctrine()->getManager();
            $em->persist($tabl);
            $em->flush();
            $removeclasse="";
            $tablTypeTabls=$this->getDoctrine()->getRepository("RestaurantBundle:TablTypeTabl")->findByTablId($tabl->getId());
            if($tablTypeTabls){
                foreach($tablTypeTabls as $tablTypeTabl){
                    $typetablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($tablTypeTabl->getTypeTablId());
                    if($typetablId){
                        $removeclasse.=' '.$typetablId->getClass();
                    }
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($tablTypeTabl);
                    $em->flush();
                } 
            }
            $classe="";
            $typetablsId=explode(",", $typetablsId);
            foreach($typetablsId as $tti){
                $typetablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($tti);
                if($typetablId){
                    $tablTypeTabl=new TablTypeTabl();
                    $tablTypeTabl->setTypeTablId($typetablId)->setTablId($tabl);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($tablTypeTabl);
                    $em->flush();
                    $classe.=' '.$typetablId->getClass();
                }
            }
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","classe"=>$classe,"removeclasse"=>$removeclasse,"id"=>$tabl->getId()));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
}
