<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\Customer;
use RestaurantBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerController extends Controller
{
    /**
     * @Route("/customer")
     */
    public function indexAction($page=1)
    {
        $limit =30;
        $page=$page-1;
    	$customers=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->getAllCustomers($limit,$page);
        $nbrcustomers=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->getCountCustomers();
        $pagination=round(($nbrcustomers/$limit)+0.49);
        $pages=array();
        for($i=1;$i<=$pagination;$i++){
            $pages[]=$i;
        }
        return $this->render('RestaurantBundle:customer:index.html.twig',array('customers'=>$customers,'pagination'=>$pagination,'page'=>($page+1),'pages'=>$pages));
    }

    /**
     * @Route("/customer/add")
     */
    public function addAction(){
        return $this->render('RestaurantBundle:customer:add.html.twig');
    }

    /**
     * @Route("/customer/edit/{id}")
     */
    public function editAction($id){
    	$customer=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->findOneById($id);
    	if($customer){
    		return $this->render('RestaurantBundle:customer:edit.html.twig',array('customer'=>$customer));
    	}
    }

    /**
     * @Route("/customer/new")
     */
    public function newAction(Request $request){
        $customer=new Customer();
        $post_customer=$request->get("customer");
        if(isset($post_customer)){
            if($customer){
                $required=array("first_name","last_name","email","mobile_number","phone_number","sexe","address",
                    "country","city","postal_code","date_birthday","langue","fax","status","favorite_food",
                    "favorite_drink","favorite_table","favorite_server","handicape","diet","note");
                foreach ($required as $v) {
                    if(!isset($v)){
                        exit;
                    }
                }
                $customer->setFirstName($post_customer["first_name"])
                        ->setLastName($post_customer["last_name"])
                        ->setEmail($post_customer["email"])
                        ->setMobileNumber($post_customer["mobile_number"])
                        ->setPhoneNumber($post_customer["phone_number"])
                        ->setSexe($post_customer["sexe"])
                        ->setAddress($post_customer["address"])
                        ->setCountry($post_customer["country"])
                        ->setCity($post_customer["city"])
                        ->setPostalCode($post_customer["postal_code"])
                        ->setDateBirthday(new \DateTime($post_customer["date_birthday"]))
                        ->setLangue($post_customer["langue"])
                        ->setFax($post_customer["fax"])
                        //->setPicture($post_customer["picture"])
                        ->setStatus($post_customer["status"])
                        ->setFavoriteFood($post_customer["favorite_food"])
                        ->setFavoriteDrink($post_customer["favorite_drink"])
                        ->setFavoriteTable($post_customer["favorite_table"])
                        ->setFavoriteServer($post_customer["favorite_server"])
                        ->setHandicape($post_customer["handicape"])
                        ->setDiet($post_customer["diet"])
                        ->setNote($post_customer["note"]);
                if(isset($post_customer["vip"]) && $post_customer["vip"]=="on")
                    $customer->setVip(1);
                else
                    $customer->setVip(0);
                if(isset($post_customer["newsletter"]) && $post_customer["newsletter"]=="on")
                    $customer->setNewsletter(1);
                else
                    $customer->setNewsletter(0);
            	if(isset($post_customer['company_id']) && !empty($post_customer['company_id']) && is_numeric($post_customer['company_id']) && $post_customer['company_id']>0)
            		$company_id=(int) $post_customer['company_id'];
            	else
            		$company_id=1;
            	$company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($company_id);
        		if($company){
        			$customer->setCompanyId($company);
        		}
                $em=$this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
                return $this->redirect( $this->generateUrl('customer_edit',array("id"=>$customer->getId())) );
            }
        }
    }
    /**
     * @Route("/customer/saveedit/{id}")
     */
    public function saveAction(Request $request,$id){
        $required=array("first_name","last_name","email","mobile_number","phone_number","sexe","address",
            "country","city","postal_code","date_birthday","langue","fax","status","favorite_food",
            "favorite_drink","favorite_table","favorite_server","handicape","diet","note");
        foreach ($required as $v) {
            if(!isset($v)){
                exit;
            }
        }
        $customer=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->findOneById($id);
        $post_customer=$request->get("customer");
        if(isset($post_customer)){
            if($customer){
                $customer->setFirstName($post_customer["first_name"])
                		->setLastName($post_customer["last_name"])
                        ->setEmail($post_customer["email"])
                        ->setMobileNumber($post_customer["mobile_number"])
                        ->setPhoneNumber($post_customer["phone_number"])
                        ->setSexe($post_customer["sexe"])
                        ->setAddress($post_customer["address"])
                        ->setCountry($post_customer["country"])
                        ->setCity($post_customer["city"])
                        ->setPostalCode($post_customer["postal_code"])
                        ->setDateBirthday(new \DateTime($post_customer["date_birthday"]))
                        ->setLangue($post_customer["langue"])
                        ->setFax($post_customer["fax"])
                        //->setPicture($post_customer["picture"])
                        ->setStatus($post_customer["status"])
                        ->setFavoriteFood($post_customer["favorite_food"])
                        ->setFavoriteDrink($post_customer["favorite_drink"])
                        ->setFavoriteTable($post_customer["favorite_table"])
                        ->setFavoriteServer($post_customer["favorite_server"])
                        ->setHandicape($post_customer["handicape"])
                        ->setDiet($post_customer["diet"])
                        ->setNote($post_customer["note"]);
                if(isset($post_customer["vip"]) && $post_customer["vip"]=="on")
                    $customer->setVip(1);
                else
                    $customer->setVip(0);
                if(isset($post_customer["newsletter"]) && $post_customer["newsletter"]=="on")
                    $customer->setNewsletter(1);
                else
                    $customer->setNewsletter(0);
                if(isset($post_customer['company_id']) && !empty($post_customer['company_id']) && is_numeric($post_customer['company_id']) && $post_customer['company_id']>0)
            		$company_id=(int) $post_customer['company_id'];
            	else
            		$company_id=1;
            	$company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($company_id);
        		if($company){
        			$customer->setCompanyId($company);
        		}
                $em=$this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
                return $this->redirect( $this->generateUrl('customer_edit',array("id"=>$id)) );
            }
        }
    }
    /**
     * @Route("/customer/delete/{id}")
     */
    public function deleteAction($id){
        $customer=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->findOneById($id);
        if($customer){
            $em=$this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }

    /**
     * @Route("/customer/all.json")
     */
    public function jsonAction()
    {
        $customers=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->getCustomersNotEmpty();
        return $this->render('RestaurantBundle:customer:json.html.twig',array('customers'=>$customers));
    }
}
