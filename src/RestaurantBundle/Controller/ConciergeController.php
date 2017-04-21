<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\Concierge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConciergeController extends Controller
{
    /**
     * @Route("/concierge/new")
     */
    public function newAction(Request $request){
        $concierge=new Concierge();
        $post_concierge=$request->get("concierge");
        if(isset($post_concierge['company_id'])){
            $company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($post_concierge['company_id']);
            if($company && $concierge){
                $concierge->setFirstName($post_concierge["first_name"])
                        ->setLastName($post_concierge["last_name"])
                        ->setCompanyId($company)
                        ->setEmail($post_concierge["email"])
                        ->setJob($post_concierge["job"])
                        ->setMobileNumber($post_concierge["mobile_number"])
                        ->setFixeNumber($post_concierge["fixe_number"])
                        ->setSexe($post_concierge["sexe"]);
                $em=$this->getDoctrine()->getManager();
                $em->persist($concierge);
                $em->flush();
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","post"=>$post_concierge,"id"=>$concierge->getId()));
            }else if(!$company){
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"notexist"));
            }
        }
    }
    /**
     * @Route("/concierge/saveedit/{id}")
     */
    public function saveAction(Request $request,$id){
        $concierge=$this->getDoctrine()->getRepository("RestaurantBundle:Concierge")->findOneById($id);
        $post_concierge=$request->get("concierge");
        if(isset($post_concierge['company_id'])){
            $company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($post_concierge['company_id']);
            if($company && $concierge){
                $concierge->setFirstName($post_concierge["first_name"])
                        ->setLastName($post_concierge["last_name"])
                        ->setCompanyId($company)
                        ->setEmail($post_concierge["email"])
                        ->setJob($post_concierge["job"])
                        ->setMobileNumber($post_concierge["mobile_number"])
                        ->setFixeNumber($post_concierge["fixe_number"])
                        ->setSexe($post_concierge["sexe"]);
                $em=$this->getDoctrine()->getManager();
                $em->persist($concierge);
                $em->flush();
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","post"=>$post_concierge,"id"=>$concierge->getId()));
            }else if(!$concierge){
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"notexist"));
            }
        }
    }
    /**
     * @Route("/concierge/delete/{id}")
     */
    public function deleteAction($id){
        $concierge=$this->getDoctrine()->getRepository("RestaurantBundle:Concierge")->findOneById($id);
        if($concierge){
            $em=$this->getDoctrine()->getManager();
            $em->remove($concierge);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
}
