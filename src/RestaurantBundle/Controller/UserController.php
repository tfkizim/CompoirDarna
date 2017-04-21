<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\User;
use RestaurantBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * @Route("/user")
     */
    public function indexAction()
    {
    	$users=$this->getDoctrine()->getRepository("RestaurantBundle:User")->findAll();
        return $this->render('RestaurantBundle:user:index.html.twig',array('users'=>$users));
    }

    /**
     * @Route("/user/add")
     */
    public function addAction(){
        return $this->render('RestaurantBundle:user:add.html.twig');
    }

    /**
     * @Route("/user/edit/{id}")
     */
    public function editAction($id){
    	$user=$this->getDoctrine()->getRepository("RestaurantBundle:User")->findOneById($id);
    	if($user){
    		return $this->render('RestaurantBundle:user:edit.html.twig',array('user'=>$user));
    	}
    }

    /**
     * @Route("/user/new")
     */
    public function newAction(Request $request){
        $user=new User();
        $post_user=$request->get("user");
        if(isset($post_user)){
            if($user){
                $required=array("first_name","last_name","email","mobile_number","fixe_number","sexe","password",
                    "job","date_birthday","facebook","twitter","whatsapp","googleplus","langue");//,"picture"

                foreach ($required as $v) {
                    if(!isset($post_user[$v])){
                        exit;
                    }
                }
                $user->setFirstName($post_user["first_name"])
                        ->setLastName($post_user["last_name"])
                        ->setEmail($post_user["email"])
                        ->setMobileNumber($post_user["mobile_number"])
                        ->setFixeNumber($post_user["fixe_number"])
                        ->setSexe($post_user["sexe"])
                        ->setPassword($post_user["password"])
                        ->setJob($post_user["job"])
                        //->setPicture($post_user["picture"])
                        ->setDateBirthday(new \DateTime($post_user["date_birthday"]))
                        ->setFacebook($post_user["facebook"])
                        ->setTwitter($post_user["twitter"])
                        ->setwhatsapp($post_user["whatsapp"])
                        ->setGoogleplus($post_user["googleplus"])
                        ->setLangue($post_user["langue"]);
                
            	/*if(isset($post_user['company_id']) && !empty($post_user['company_id']) && is_numeric($post_user['company_id']) && $post_user['company_id']>0)
            		$company_id=(int) $post_user['company_id'];
            	else
            		$company_id=1;

            	$company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($company_id);
        		if($company){
        			$user->setCompanyId($company);
        		}*/
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirect( $this->generateUrl('user_edit',array("id"=>$user->getId())) );
            }
        }
    }
    /**
     * @Route("/user/saveedit/{id}")
     */
    public function saveAction(Request $request, $id){
        $required=array("first_name","last_name","email","mobile_number","fixe_number","sexe","password",
                    "job","date_birthday","facebook","twitter","whatsapp","googleplus","langue");//,"picture"
        $post_user=$request->get("user");
        foreach ($required as $v) {
            if(!isset($post_user[$v])){
                exit;
            }
        }
        $user=$this->getDoctrine()->getRepository("RestaurantBundle:User")->findOneById($id);
        if(isset($post_user)){
            if($user){
                $user->setFirstName($post_user["first_name"])
                        ->setLastName($post_user["last_name"])
                        ->setEmail($post_user["email"])
                        ->setMobileNumber($post_user["mobile_number"])
                        ->setFixeNumber($post_user["fixe_number"])
                        ->setSexe($post_user["sexe"])
                        ->setJob($post_user["job"])
                        //->setPicture($post_user["picture"])
                        ->setDateBirthday(new \DateTime($post_user["date_birthday"]))
                        ->setFacebook($post_user["facebook"])
                        ->setTwitter($post_user["twitter"])
                        ->setwhatsapp($post_user["whatsapp"])
                        ->setGoogleplus($post_user["googleplus"])
                        ->setLangue($post_user["langue"]);
                if(!empty($post_user["password"]))
                    $user->setPassword($post_user["password"]);
                /*
                if(isset($post_user['company_id']) && !empty($post_user['company_id']) && is_numeric($post_user['company_id']) && $post_user['company_id']>0)
            		$company_id=(int) $post_user['company_id'];
            	else
            		$company_id=1;
            	$company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($company_id);
        		if($company){
        			$user->setCompanyId($company);
        		}*/
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirect( $this->generateUrl('user_edit',array("id"=>$id)) );
            }
        }
    }
    /**
     * @Route("/user/delete/{id}")
     */
    public function deleteAction($id){
        $user=$this->getDoctrine()->getRepository("RestaurantBundle:User")->findOneById($id);
        if($user){
            $em=$this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }

    /**
     * @Route("/user/all.json")
     */
    public function jsonAction()
    {
        $users=$this->getDoctrine()->getRepository("RestaurantBundle:User")->findAll();
        return $this->render('RestaurantBundle:user:json.html.twig',array('users'=>$users));
    }
}
