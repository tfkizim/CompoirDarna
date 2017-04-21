<?php

namespace RestaurantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Config;
use RestaurantBundle\Entity\Service;
use RestaurantBundle\Entity\State;
use RestaurantBundle\Entity\Offer;
use RestaurantBundle\Entity\Occasion;
use RestaurantBundle\Entity\Floor;
use RestaurantBundle\Form\ConfigType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use RestaurantBundle\Models\Document;
use Symfony\Component\HttpFoundation\Session\Session;

class ConfigController extends Controller
{
    /**
     * @Route("/config")
     */
    public function indexAction()
    {
        //Create if not exists configurations
    	$SITECONFIG=array("SITENAME","SITEDESCRIPTION","SITEEMAIL","SITELOGO","SITELOGOWIDTH","SITELOGOHEIGTH","ARRAYOPENINGHOURS","SITEOPENINGHOURS","ARRAYINTERVALS","WHATSAPPNUMBER","WHATSAPPCHATNUMBER","WHATSAPPPASSWORD","WHATSAPPCONFIRM","WHATSAPPPENDING","WHATSAPPCANCEL","WHATSAPPLATITUDE","WHATSAPPLONGITUDE","DEFAULTCOMPANY");
    	foreach($SITECONFIG as $v){
	    	${$v}=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName($v);
	    	if(!${$v}){
	    		${$v}=new Config();
	    		${$v}->setName($v);
	    		$em=$this->getDoctrine()->getManager();
	    		$em->persist(${$v});
	    		$em->flush();
	    	}
	    	${$v}=${$v}->getValue();
    	}
        //Openning hours
        $days=array(
            "Lundi"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>""),
            "Mardi"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>""),
            "Mercredi"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>""),
            "Jeudi"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>""),
            "Vendredi"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>""),
            "Samedi"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>""),
            "Dimanche"=>array("OPENHOUR"=>"","CLOSEHOUR"=>"","INTERVAL"=>"")
        );
        if($openhours=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("ARRAYOPENINGHOURS")){
            if(!empty($openhours->getValue())){
                $days=json_decode($openhours->getValue());
            }
        }
        $SITEOPENINGHOURS=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("SITEOPENINGHOURS");
        if(empty($SITEOPENINGHOURS->getValue())){
            $SITEOPENINGHOURS->setValue(json_encode($days));
            $em=$this->getDoctrine()->getManager();
            $em->persist($SITEOPENINGHOURS);
            $em->flush();
        }else{
            $days=(array) json_decode($SITEOPENINGHOURS->getValue());
        }
        //Interval config
        if($interval=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("ARRAYINTERVALS")){
            if(!empty($interval->getValue())){
                $intervalarray=(array) json_decode($interval->getValue());
            }
        }
        //Render All Services 
        $Services=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findAll();
        $render_services=array();
        foreach($Services as $service){
            $service_hours=(array) json_decode($service->getValeur());
            $render_services[]=array(
                "id"=>$service->getId(),
                "name"=>$service->getName(),
                "valeur"=>$service_hours,
                "ordre"=>$service->getOrdre(),
            );
        }
        //Render All Floors
        $Floors=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findAll();
        //Render All TypeTabls
        $TypeTabls=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findAll();
        //Render All Occasions
        $Occasions=$this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->findAll();
        //Render All States
        $States=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findAll();
        //Render All Offers
        $Offers=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->findAll();
        //render configuration
        return $this->render('RestaurantBundle:config:index.html.twig',array(
        	"SITENAME"=>$SITENAME,
        	"SITEDESCRIPTION"=>$SITEDESCRIPTION,
        	"SITEEMAIL"=>$SITEEMAIL,
            "ARRAYOPENINGHOURS"=>$ARRAYOPENINGHOURS,
        	"SITELOGO"=>$SITELOGO,
        	"SITELOGOWIDTH"=>$SITELOGOWIDTH,
            "SITELOGOHEIGTH"=>$SITELOGOHEIGTH,
        	"INTERVALHOURS"=>$intervalarray,
            "SITEOPENINGHOURS"=>$days,
            "ARRAYINTERVALS"=>$ARRAYINTERVALS,
            "DEFAULTCOMPANY"=>$DEFAULTCOMPANY,
            "SERVICES"=>$render_services,
            "FLOORS"=>$Floors,
            "TYPETABLS"=>$TypeTabls,
            "OCCASIONS"=>$Occasions,
            "STATES"=>$States,
            "OFFERS"=>$Offers,
            "WHATSAPPNUMBER"=>$WHATSAPPNUMBER,
            "WHATSAPPPASSWORD"=>$WHATSAPPPASSWORD,
            "WHATSAPPCONFIRM"=>$WHATSAPPCONFIRM,
            "WHATSAPPPENDING"=>$WHATSAPPPENDING,
            "WHATSAPPCANCEL"=>$WHATSAPPCANCEL,
            "WHATSAPPLATITUDE"=>$WHATSAPPLATITUDE,
            "WHATSAPPLONGITUDE"=>$WHATSAPPLONGITUDE,
            "WHATSAPPCHATNUMBER"=>$WHATSAPPCHATNUMBER,
        ));

    }
    /**
     * @Route("/saveconfig")
     */
    public function saveAction(Request $request)
    {
        //Update text configs
    	$SITECONFIG=array("SITENAME","SITEDESCRIPTION","SITEEMAIL","SITELOGOWIDTH","SITELOGOHEIGTH","ARRAYOPENINGHOURS","ARRAYINTERVALS","WHATSAPPNUMBER","WHATSAPPPASSWORD","WHATSAPPCONFIRM","WHATSAPPPENDING","WHATSAPPCANCEL","WHATSAPPLATITUDE","WHATSAPPLONGITUDE","WHATSAPPCHATNUMBER","DEFAULTCOMPANY");
    	foreach($SITECONFIG as $v){
    		${$v."_value"}=$request->get($v);
			${$v}=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName($v);
            if(${$v}){
    			${$v}->setValue(${$v."_value"});
    			$em=$this->getDoctrine()->getManager();
        		$em->persist(${$v});
        		$em->flush();
            }
    	}
        if(!empty($request->get("indextab")) && is_numeric($request->get("indextab")) && $request->get("indextab")>0){
            $index=$request->get("indextab");
            $session=new Session();
            $session->set("indextab",$index);
        }
        //Update Logo
        $status=true;
        $message="";
        $uploadedURL="";
        $image=$request->files->get("logo");
        if(($image instanceof UploadedFile) && ($image->getError()=="0")){
            if(($image->getSize()<2000000)){
                $originalName=$image->getClientOriginalName();
                $name_array=explode(".", $originalName);
                $file_type=$name_array[sizeof($name_array)-1];
                $valid_filetypes= array("jpg","png");
                if(in_array(strtolower($file_type),$valid_filetypes)){
                    $dir="uploads";
                    $separator="/";
                    $document=new Document();
                    $document->setFile($image);
                    $document->setUploadDirectory($dir);
                    $document->processFile();
                    $uploadedURL=$document->getUploadDirectory().DIRECTORY_SEPARATOR.$image->getBaseName();
                    $uploadedURL=$dir.$separator.str_replace(DIRECTORY_SEPARATOR,$separator,$document->getFilePersistencePath());
                }else{
                    $status=false;
                    $message="Invalid file type";
                }
            }else{
                $status=false;
                $message="File exceeds limit";
            }
        }else{
            $status=false;
            $message="File error";
        }
        if($status && !empty($uploadedURL)){
            $SITELOGO=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("SITELOGO");
            if($SITELOGO){
                $SITELOGO->setValue($uploadedURL);
                $em=$this->getDoctrine()->getManager();
                $em->persist($SITELOGO);
                $em->flush();
            }
        }
        //Update Openning hours
        /*$SITEOPENINGHOURS=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("SITEOPENINGHOURS");
        if($SITEOPENINGHOURS){
            if(!empty($SITEOPENINGHOURS->getValue())){
                $days=(array) json_decode($SITEOPENINGHOURS->getValue());
                $dayspost=$request->get("day");
                foreach($dayspost as $day=>$post){
                    $days[$day]->OPENHOUR=$dayspost[$day]["OPENHOUR"];
                    $days[$day]->CLOSEHOUR=$dayspost[$day]["CLOSEHOUR"];
                    $days[$day]->INTERVAL=$dayspost[$day]["INTERVAL"];
                }
                $SITEOPENINGHOURS->setValue(json_encode($days));
                $em=$this->getDoctrine()->getManager();
                $em->persist($SITEOPENINGHOURS);
                $em->flush();
            }
        }*/
        //Update Services
        $servicespost=$request->get("service");
        foreach($servicespost as $id=>$servicepost){

            $service=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($id);
            if($service){
                $days=(array) json_decode($service->getValeur());
                
                foreach($servicepost as $day=>$post){
                    $days[$day]->OPENHOUR=$servicepost[$day]["OPENHOUR"];
                    $days[$day]->CLOSEHOUR=$servicepost[$day]["CLOSEHOUR"];
                    $days[$day]->INTERVAL=$servicepost[$day]["INTERVAL"];
                }
                $service->setValeur(json_encode($days));
                $em=$this->getDoctrine()->getManager();
                $em->persist($service);
                $em->flush();
            }

        }
        $floorspost=$request->get("floor");
        foreach($floorspost as $id=>$floorpost){

            $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Floor")->findOneById($id);
            if($floor){
                $floor->setName($floorpost['name']);
                $floor->setNbrCovert($floorpost['nbr_covert']);
                $floor->setNbrServer($floorpost['nbr_server']);

                $em=$this->getDoctrine()->getManager();
                $em->persist($floor);
                $em->flush();
            }

        }
        $offerspost=$request->get("offer");
        foreach($offerspost as $id=>$offerpost){

            $offer=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->findOneById($id);
            if($offer){
                $offer->setName($offerpost['name']);
                $offer->setIcon($offerpost['icon']);

                $em=$this->getDoctrine()->getManager();
                $em->persist($offer);
                $em->flush();
            }

        }
        $typetablspost=$request->get("typetabl");
        foreach($typetablspost as $id=>$typetablpost){

            $typetabl=$this->getDoctrine()->getRepository("RestaurantBundle:TypeTabl")->findOneById($id);
            if($typetabl){
                $typetabl->setName($typetablpost['name']);
                $typetabl->setClass($typetablpost['class']);
                $typetabl->setMinCovert($typetablpost['min_covert']);
                $typetabl->setMaxCovert($typetablpost['max_covert']);

                $em=$this->getDoctrine()->getManager();
                $em->persist($typetabl);
                $em->flush();
            }

        }
        $occasionspost=$request->get("occasion");
        foreach($occasionspost as $id=>$occasionpost){

            $occasion=$this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->findOneById($id);
            if($occasion){
                $occasion->setName($occasionpost['name']);
                $occasion->setIcon($occasionpost['icon']);
                $occasion->setColor($occasionpost['color']);

                $em=$this->getDoctrine()->getManager();
                $em->persist($occasion);
                $em->flush();
            }
        }
        $statespost=$request->get("state");
        foreach($statespost as $id=>$statepost){

            $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneById($id);
            if($state){
                $state->setName($statepost['name']);
                $state->setColor($statepost['color']);
                $state->setFlashed($statepost['flashed']);
                $state->setFunction($statepost['function']);

                $em=$this->getDoctrine()->getManager();
                $em->persist($state);
                $em->flush();
            }

        }
        return $this->redirect( $this->generateUrl('restaurant_config') );
    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    /**
     * @Route("/configuration/pays.json")
     */
    public function paysJsonAction()
    {
        return $this->render('RestaurantBundle:pays:json.html.twig');
    }
    /**
     * @Route("/configuration/indicatif.json")
     */
    public function indicatifJsonAction(Request $request)
    {
        $filter=$request->query->get("filter");
        if(isset($filter["filters"][0]["value"])){
            $name=strip_tags($filter["filters"][0]["value"]);
            $countries=$this->getDoctrine()->getRepository("RestaurantBundle:Country")->getFilterCountry($name);
            return $this->render('RestaurantBundle:pays:indicatif.html.twig',array('countries'=>$countries));
        }else{
            $countries=$this->getDoctrine()->getRepository("RestaurantBundle:Country")->findAll();
            return $this->render('RestaurantBundle:pays:indicatif.html.twig',array('countries'=>$countries));
        }
    }
}
