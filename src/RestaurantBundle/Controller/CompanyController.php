<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\Company;
use RestaurantBundle\Entity\Concierge;
use RestaurantBundle\Entity\TypeCompany;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompanyController extends Controller
{
    /**
     * @Route("/company")
     */
    public function indexAction($page=1)
    {
     //    $limit =30;
     //    $page=$page-1;
    	// $typecompanies=$this->getDoctrine()->getRepository("RestaurantBundle:TypeCompany")->findAll();
    	// $companies=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->getAllCompanies($limit,$page);
     //    $nbrcompanies=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->getCountCompanies();
     //    $pagination=round(($nbrcompanies/$limit)+0.49);
     //    $pages=array();
     //    for($i=1;$i<=$pagination;$i++){
     //        $pages[]=$i;
     //    }
     //    return $this->render('RestaurantBundle:company:index.html.twig',array('companies'=>$companies,"typecompanies"=>$typecompanies,'pagination'=>$pagination,'page'=>($page+1),'pages'=>$pages));



        $typecompanies=$this->getDoctrine()->getRepository("RestaurantBundle:TypeCompany")->findAll();
        $companies=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findAll(); 
         
        return $this->render('RestaurantBundle:company:index.html.twig',array('companies'=>$companies,"typecompanies"=>$typecompanies));
    }
    /**
     * @Route("/company/add")
     */
    public function addAction(){
        $typecompanies=$this->getDoctrine()->getRepository("RestaurantBundle:TypeCompany")->findAll();
        return $this->render('RestaurantBundle:company:add.html.twig',array("typecompanies"=>$typecompanies));
    }
    /**
     * @Route("/company/edit/{id}")
     */
    public function editAction($id){
    	$company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($id);
    	$typecompanies=$this->getDoctrine()->getRepository("RestaurantBundle:TypeCompany")->findAll();
    	if($company){
            $concierges=$this->getDoctrine()->getRepository("RestaurantBundle:Concierge")->findByCompanyId($company->getId());
    		return $this->render('RestaurantBundle:company:edit.html.twig',array('company'=>$company,"concierges"=>$concierges,"typecompanies"=>$typecompanies));
    	}
    }
    /**
     * @Route("/company/new")
     */
    public function newAction(Request $request){
        $company=new Company();
        $post_company=$request->get("company");
        if(isset($post_company['typecompany_id'])){
            $typecompany=$this->getDoctrine()->getRepository("RestaurantBundle:TypeCompany")->findOneById($post_company['typecompany_id']);
            if($company && $typecompany){
                $company->setName($post_company["name"])
                        ->setTypeCompanyId($typecompany)
                        ->setAddress($post_company["address"])
                        ->setDirector($post_company["director"])
                        ->setDescription($post_company["description"])
                        ->setEmail($post_company["email"])
                        ->setGoogleplus($post_company["googleplus"])
                        ->setFixe($post_company["fixe"])
                        ->setPhone($post_company["phone"])
                        ->setFacebook($post_company["facebook"])
                        ->setTwitter($post_company["twitter"]);
                $em=$this->getDoctrine()->getManager();
                $em->persist($company);
                $em->flush();
                return $this->redirect( $this->generateUrl('company_edit',array("id"=>$company->getId())) );
            }
        }
    }
    /**
     * @Route("/company/saveedit/{id}")
     */
    public function saveAction(Request $request, $id){
        $company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($id);
        $post_company=$request->get("company");
        if(isset($post_company['typecompany_id'])){
            $typecompany=$this->getDoctrine()->getRepository("RestaurantBundle:TypeCompany")->findOneById($post_company['typecompany_id']);
            if($company && $typecompany){
                $company->setName($post_company["name"])
                        ->setTypeCompanyId($typecompany)
                        ->setAddress($post_company["address"])
                        ->setDirector($post_company["director"])
                        ->setDescription($post_company["description"])
                        ->setEmail($post_company["email"])
                        ->setGoogleplus($post_company["googleplus"])
                        ->setFixe($post_company["fixe"])
                        ->setPhone($post_company["phone"])
                        ->setFacebook($post_company["facebook"])
                        ->setTwitter($post_company["twitter"]);
                $em=$this->getDoctrine()->getManager();
                $em->persist($company);
                $em->flush();
                return $this->redirect( $this->generateUrl('company_edit',array("id"=>$id)) );
            }
        }
    }
    /**
     * @Route("/company/delete/{id}")
     */
    public function deleteAction($id){
        $company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findOneById($id);
        if($company){
            $books=$company->getBooks();
            if($books){
                foreach ($books as $book) {
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($book);
                    $em->flush();
                }
            }

            $em=$this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/company/all.json")
     */
    public function jsonAction(Request $request)
    {
        $filter=$request->query->get("filter");
        if(isset($filter["filters"][0]["value"])){
            $name=strip_tags($filter["filters"][0]["value"]);
            $companies=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->getFilterCompany($name);
            return $this->render('RestaurantBundle:company:json.html.twig',array('companies'=>$companies));
        }else{
            $companies=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->findAll();
            return $this->render('RestaurantBundle:company:json.html.twig',array('companies'=>$companies));
        }
    }
}
