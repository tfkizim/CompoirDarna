<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\GroupTabl;
use RestaurantBundle\Entity\Config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupTablController extends Controller
{
    /**
     * @Route("/grouptabl/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        $name = $request->get("name");
        $orientation = $request->get("orientation");
        $floorId = $request->get("floor_id");
        $tablsId = $request->get("selected_tables_id");
        if(empty($name)){
            $name=$request->get("selected_nametabls");
        }
        
        $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($floorId);

        if($floor){
	        $grouptabl=new GroupTabl();
            $grouptabl->setName($name);
            $grouptabl->setOrientation($orientation);
            $grouptabl->setFloorId($floor);
            $grouptabl->setTopp(0);
            $grouptabl->setLeftp(0);
            
	        $em=$this->getDoctrine()->getManager();
	        $em->persist($grouptabl);
	        $em->flush();
            $names="";
            $nbrChaire="";
            $typetables=array();
            $tablsId=explode(",", $tablsId);
            $i=0;$TOP=0;$LEFT=0;
            foreach($tablsId as $ti){
                $Tabl=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($ti);
                if($Tabl){
                    if($i==0){ $TOP=$Tabl->getTopp(); $LEFT=$Tabl->getLeftp(); }
                    $Tabl->setGrouptablId($grouptabl);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($Tabl);
                    $em->flush();
                    $names.='+'.$Tabl->getName();
                    $nbrChaire+=$Tabl->getNbrChaire();
                    $classe="";
                    $tablTypeTabls=$this->getDoctrine()->getRepository("RestaurantBundle:TablTypeTabl")->findByTablId($Tabl->getId());
                    foreach($tablTypeTabls as $tablTypeTabl){
                        $typetablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($tablTypeTabl->getTypeTablId());
                        if($typetablId){
                            $classe.=' '.$typetablId->getClass();
                        }
                    }
                    $typetables[$Tabl->getId()]=$classe;
                    $i++;
                }
            }
            $grouptabl->setTopp($TOP);
            $grouptabl->setLeftp($LEFT);
            $em=$this->getDoctrine()->getManager();
            $em->persist($grouptabl);
            $em->flush();

            $names=substr($names, 1);
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","names"=>$names,'id'=>$grouptabl->getId(),'nbrChaire'=>$nbrChaire,'typetables'=>$typetables,'TOPP'=>$TOP,"LEFTP"=>$LEFT,'provisoire_id'=>$request->get("provisoire_id")));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"exist"));
        }
    }
    /**
     * @Route("/grouptabl/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $grouptabl=$this->getDoctrine()->getRepository("RestaurantBundle:GroupTabl")->findOneById($id);
        if($grouptabl){
            $tabls=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findByGrouptablId($id);
            foreach($tabls as $tabl){
                $tabl->setGrouptablId(null);
                $em=$this->getDoctrine()->getManager();
                $em->persist($tabl);
                $em->flush();
            }
            $em=$this->getDoctrine()->getManager();
            $em->remove($grouptabl);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/grouptabl/edit_drag_xhr/{id}")
     */
    public function editDragXhrAction(Request $request, $id){
        $grouptabl=$this->getDoctrine()->getRepository("RestaurantBundle:GroupTabl")->findOneById($id);
        if($grouptabl){
            $topp = $request->get("top");
            $leftp = $request->get("left");
            $grouptabl->setTopp($topp);
            $grouptabl->setLeftp($leftp);
            $em=$this->getDoctrine()->getManager();
            $em->persist($grouptabl);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
    /**
     * @Route("/grouptabl/edit_xhr/{id}")
     */
    /*public function editXhrAction(Request $request, $id){
        $grouptabl=$this->getDoctrine()->getRepository("RestaurantBundle:GroupTabl")->findOneById($id);
        if($grouptabl){
            $name = $request->get("name");
            $nbrChaire = $request->get("nbr_chaire");
            $floorId = $request->get("floor_id");
            $typegrouptablsId = $request->get("typegrouptabl_id");

            $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($floorId);
            
            $grouptabl->setName($name);
            $grouptabl->setNbrChaire($nbrChaire);
            $grouptabl->setFloorId($floor);

            $em=$this->getDoctrine()->getManager();
            $em->persist($grouptabl);
            $em->flush();
            $removeclasse="";
            $grouptablTypeGroupTabls=$this->getDoctrine()->getRepository("RestaurantBundle:GroupTablTypeGroupTabl")->findByGroupTablId($grouptabl->getId());
            if($grouptablTypeGroupTabls){
                foreach($grouptablTypeGroupTabls as $grouptablTypeGroupTabl){
                    $typegrouptablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeGroupTabl")->findOneById($grouptablTypeGroupTabl->getTypeGroupTablId());
                    if($typegrouptablId){
                        $removeclasse.=' '.$typegrouptablId->getClass();
                    }
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($grouptablTypeGroupTabl);
                    $em->flush();
                } 
            }
            $classe="";
            $typegrouptablsId=explode(",", $typegrouptablsId);
            foreach($typegrouptablsId as $tti){
                $typegrouptablId=$this->getDoctrine()->getRepository("RestaurantBundle:TypeGroupTabl")->findOneById($tti);
                if($typegrouptablId){
                    $grouptablTypeGroupTabl=new GroupTablTypeGroupTabl();
                    $grouptablTypeGroupTabl->setTypeGroupTablId($typegrouptablId)->setGroupTablId($grouptabl);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($grouptablTypeGroupTabl);
                    $em->flush();
                    $classe.=' '.$typegrouptablId->getClass();
                }
            }
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","classe"=>$classe,"removeclasse"=>$removeclasse,"id"=>$grouptabl->getId()));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }*/
}
