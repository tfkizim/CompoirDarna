<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\BookTabl;
use RestaurantBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Book;
use RestaurantBundle\Entity\Offer;
use RestaurantBundle\Entity\Occasion;
use RestaurantBundle\Entity\Service;
use RestaurantBundle\Entity\State;
use RestaurantBundle\Entity\Company;
use RestaurantBundle\Entity\Customer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use WhatsappBundle\Models\SqliteMessageStore;
use WhatsappBundle\Models\vCard;
use WhatsappBundle\Models\WhatsProt;

class BookController extends Controller
{
    public function changeStateAction($book,$state){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $state=(int) $state;
        $book=(int) $book;
        $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->find($state);
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($book);
        if($book && $state){
            $BeginingWaitingTime="";
            if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                $BeginingWaitingTime=new \DateTime();
                $book->setBeginingWaitingTime($BeginingWaitingTime);
                $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
            }
            $book->setStateId($state);
            $em=$this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();


            $user = $this->get('security.context')->getToken()->getUser();
            $notif=new Notification();
            if($user) $notif->setUserId($user);
            if($book) $notif->setBookId($book);
            $message=$user->getLastName()." ".$user->getFirstName()." vient de modifier l'état de la réservation en ".$state->getName()." pour le ".$book->getDateBook()->format("d, F Y \à H\:i").".";
            if(!empty($message)) $notif->setMessage($message);
            $notif->setTypeNotif("success");
            $notif->setViewed(0);
            $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
            $em=$this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();

            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"orderstate"=>$state->getOrderInFilter(),"stateid"=>$state->getId(),"statename"=>$state->getName(),"class"=>$state->getColor(),"stateslugify"=>$state->getFunction()));
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function bookLateAction(Request $request){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        if(!empty($request->get("book")) && is_numeric($request->get("book")) && $request->get("book")>0){
            $book=(int) $request->get("book");
            $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("late");
            $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($book);
            if($book && $state){
                $BeginingWaitingTime="";
                if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                    $BeginingWaitingTime=new \DateTime();
                    $book->setBeginingWaitingTime($BeginingWaitingTime);
                    $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                }
                $book->setStateId($state);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();

                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","state"=>$state->getColor(),"BeginingWaitingTime"=>$BeginingWaitingTime));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function bookNoShowAction(Request $request){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        if(!empty($request->get("book")) && is_numeric($request->get("book")) && $request->get("book")>0){
            $book=(int) $request->get("book");
            $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("noshow");
            $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($book);
            if($book && $state){
                $BeginingWaitingTime="";
                if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                    $BeginingWaitingTime=new \DateTime();
                    $book->setBeginingWaitingTime($BeginingWaitingTime);
                    $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                }
                $book->setStateId($state);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();

                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","state"=>$state->getColor(),"BeginingWaitingTime"=>$BeginingWaitingTime));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function bookLiberateTablAction(Request $request){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        if(!empty($request->get("book")) && is_numeric($request->get("book")) && $request->get("book")>0 && !empty($request->get("table")) && is_numeric($request->get("table")) && $request->get("table")>0){
            $book=(int) $request->get("book");
            $table=(int) $request->get("table");
            $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($book);
            $table=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->find($table);
            if($book && $table){
                $newtables='';
                foreach($book->getBooktabls() as $bt){
                    if($bt->getTablId()->getId()==$table->getId()){
                        $em=$this->getDoctrine()->getManager();
                        $em->remove($bt);
                        $em->flush();
                        $rep=true;
                    }else{
                        if (empty($newtables)) {
                            $newtables .= '<span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                        } else {
                            $newtables .= ' + <span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                        }
                    }
                }
            }
        }
        if(isset($rep)){
            $newtables='<i class="fa fa-circle"></i>'.$newtables;
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok",'newtables'=>$newtables,'message'=>"La table ".$bt->getTablId()->getName()." a été libérée avec succès."));
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function bookFreeTablsAction(Request $request){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        if(!empty($request->get("book")) && is_numeric($request->get("book")) && $request->get("book")>0){
            $book=(int) $request->get("book");
            $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("noshow");
            $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($book);
            if($book && $state){
                $BeginingWaitingTime="";
                if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                    $BeginingWaitingTime=new \DateTime();
                    $book->setBeginingWaitingTime($BeginingWaitingTime);
                    $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                }
                $book->setStateId($state);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();
                /*foreach($book->getBooktabls() as $bt){
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($bt);
                    $em->flush();
                }*/

                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","state"=>$state->getColor(),"BeginingWaitingTime"=>$BeginingWaitingTime));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    /**
     * @Route("/saveedit/{id}")
     */
    public function saveAction(Request $request,$id){
        $book = $this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($id);
        if($book){

            $BeginingWaitingTime="";
            $Book = $request->get("book");
            $user = $this->get('security.context')->getToken()->getUser();
            $offer = $this->getDoctrine()->getRepository("RestaurantBundle:Offer")->find($Book["offer"]);
            $floor = $this->getDoctrine()->getRepository("RestaurantBundle:Floor")->find($Book["floor"]);
            if(!empty($Book["state"]) && is_numeric($Book["state"]))
                $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->find($Book["state"]);
            else
                $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("reserved");
            $occasion = $this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->find($Book["occasion"]);
            $company = $this->getDoctrine()->getRepository("RestaurantBundle:Company")->find($Book["company"]);
            if (isset($Book["hour"]) && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/", $Book["hour"], $output)) {
                $Bookdate = $Book["date"] . " " . $output[2];
                $Bookservice = $output[1];
            }
            if (isset($Book["hour"]) && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/", $Book["hour"], $output)) {
                $Book["date"] = $Book["date"] . " " . $output[2];
                $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->find($output[1]);
                if ($service) $book->setServiceId($service);
            }
            if (!empty($Book["pax"]) && is_numeric($Book["pax"]) && $Book["pax"] > 0) $book->setPax($Book["pax"]);
            if (!empty($Book["noteadmin"])) $book->setNoteAdmin($Book["noteadmin"]);
            if (!empty($Book["notecustomer"])) $book->setNoteCustomer($Book["notecustomer"]);
            if (!empty($Book["date"])) $book->setDateBook(new \DateTime($Book["date"]));
            if ($offer) $book->setOfferId($offer);
            if ($state) {
                if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                    $BeginingWaitingTime=new \DateTime();
                    $book->setBeginingWaitingTime($BeginingWaitingTime);
                    $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                }
                $book->setStateId($state);
            }
            if ($floor) $book->setFloorId($floor);
            if ($user) $book->setUserId($user);


            if ($occasion) $book->setOccasionId($occasion);
            if ($company) $book->setCompanyId($company);
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            $oldtabls="";
            foreach ($book->getBooktabls() as $bt) {
                if (empty($oldtabls)) {
                    $oldtabls .= $bt->getTablId()->getName();
                } else {
                    $oldtabls .= '+'.$bt->getTablId()->getName();
                }
                $em = $this->getDoctrine()->getManager();
                $em->remove($bt);
                $em->flush();
            }

            if($state && $state->getFunction()!="free" && $state->getFunction()!="cancelled"){
                if (!empty($Book["tables_name"])) {
                    $Book["tables_name"] = trim($Book["tables_name"]);
                    $Book["tables_name"] = str_replace(" ", "", $Book["tables_name"]);
                    $tables = explode("+", $Book["tables_name"]);

                    if ($tables) {
                        foreach ($tables as $tablename) {
                            $tablename = (string)$tablename;
                            $booktable = new BookTabl();
                            $table = $this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneByName($tablename);
                            if ($table) {
                                $booktable->setBookId($book);
                                $booktable->setTablId($table);
                                $em = $this->getDoctrine()->getManager();
                                $em->persist($booktable);
                                $em->flush();
                            }
                        }
                    }
                }
            }

            if(!empty($Book["tables_name"]) && $oldtabls!=$Book["tables_name"]){
                $notif=new Notification();
                if($user) $notif->setUserId($user);
                if($book) $notif->setBookId($book);
                $message=$user->getLastName()." ".$user->getFirstName()." vient de modifier les tables du réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i")." les nouvelles tables sont : ".$Book["tables_name"];
                if(!empty($message)) $notif->setMessage($message);
                $notif->setTypeNotif("info");
                $notif->setViewed(0);
                $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                $em=$this->getDoctrine()->getManager();
                $em->persist($notif);
                $em->flush();
            }
            return $this->redirectToRoute('book_edit', ["id"=>$book->getId()]);
        }
    }
    /**
     * @Route("/book/remote_add_xhr")
     */
    public function remoteAddXhrAction(Request $request){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $customer_lastname=$request->get("lastname");
        $customer_email=$request->get("email");
        $customer_mobile_number=$request->get("mobile_number");
        $customer_indicatif_mobile_number=$request->get("indicatif_mobile_number");
        $customer_langue=$request->get("langue");
        $book_noteadmin=$request->get("noteadmin");
        $book_date=$request->get("date");
        $book_hour=$request->get("hour");
        $book_state=$request->get("state");
        $book_pax=$request->get("pax");
        if(!empty($customer_lastname) && !empty($customer_email) && !empty($customer_mobile_number) && !empty($customer_langue) && !empty($book_date) && !empty($book_hour) && !empty($book_pax)){
            if(!$customer=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->findOneByEmail($customer_email)){
                $customer = new Customer();
                $customer->setSexe("Mr.");
                $customer->setFirstName("");
                $customer->setLastName($customer_lastname);
                $customer->setEmail($customer_email);
                $customer->setIndicatifMobileNumber($customer_indicatif_mobile_number);
                $customer->setMobileNumber($customer_mobile_number);
                $customer->setLangue($customer_langue);
                $customer->setVip(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
            }
            if(!empty($customer)){
                if(!$book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneBy(array("customer_id"=>$customer,"date_book"=>(new \DateTime($book_date." ".$book_hour))))){
                    $book = new Book();
                    $book->setBlocked(0);
                    $book->setPax($book_pax);
                    $book->setDateBook(new \DateTime($book_date." ".$book_hour));
                    $book->setCustomerId($customer);
                    $book->setOfferId(null);
                    $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("reserved");
                    $book->setStateId($state);
                    $book->setFloorId(null);
                    $book->setUserId(null);
                    $book->setOccasionId(null);
                    $book->setCompanyId(null);
                    $book->setNoteAdmin($book_noteadmin);
                    $date = new \Datetime("1970-01-01 " . $book_hour);
                    $hournow = $date->format("U");
                    $interval = $date->getTimestamp();
                    $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->findBetweenInterval($interval);
                    if (!$service) $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneBy(array());
                    $book->setServiceId($service);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                }else{
                    if($book_state==3){
                        $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("cancelled");
                        $book->setStateId($state);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($book);
                        $em->flush();
                    }
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok"));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"error"));
    }
    /**
     * @Route("/book/cron_add_xhr")
     */
    public function cronAddXhrAction(Request $request){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $customer_lastname=$request->get("lastname");
        $customer_email=$request->get("email");
        $customer_mobile_number=$request->get("mobile_number");
        $customer_indicatif_mobile_number=$request->get("indicatif_mobile_number");
        $customer_langue=$request->get("langue");
        $book_noteadmin=$request->get("noteadmin");
        $book_date=$request->get("date");
        $book_hour=$request->get("hour");
        $book_pax=$request->get("pax");
        if(!empty($customer_lastname) && !empty($customer_email) && !empty($customer_mobile_number) && !empty($customer_langue) && !empty($book_date) && !empty($book_hour) && !empty($book_pax)){
            if($customer=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->findOneByEmail($customer_email)){
                if($customer->getLastName()!=$customer_lastname){
                    $customer->setLastName($customer_lastname);
                }
                if($customer->getIndicatifMobileNumber()!=$customer_indicatif_mobile_number){
                    $customer->setIndicatifMobileNumber($customer_indicatif_mobile_number);
                }
                if($customer->getMobileNumber()!=$customer_mobile_number){
                    $customer->setMobileNumber($customer_mobile_number);
                }
                if($customer->getLangue()!=$customer_langue){
                    $customer->setLangue($customer_langue);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
            }else{
                $customer = new Customer();
                $customer->setSexe("Mr.");
                $customer->setFirstName("");
                $customer->setLastName($customer_lastname);
                $customer->setEmail($customer_email);
                $customer->setIndicatifMobileNumber($customer_indicatif_mobile_number);
                $customer->setMobileNumber($customer_mobile_number);
                $customer->setLangue($customer_langue);
                $customer->setVip(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
            }
            if(!empty($customer)){
                echo "1";
                if($book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneBy(array("customerId"=>$customer,"dateBook"=>(new \DateTime($book_date." ".$book_hour))))){
                    echo "2";
                    if($book->getPax()!=$book_pax){
                        $book->setPax($book_pax);
                    }
                    if($book->getNoteAdmin()!=strip_tags($book_noteadmin)){
                        $book->setNoteAdmin(strip_tags($book_noteadmin));
                    }
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                }else{
                    echo "3";
                    $book = new Book();
                    $book->setBlocked(0);
                    $book->setPax($book_pax);
                    $book->setDateBook(new \DateTime($book_date." ".$book_hour));
                    $book->setCustomerId($customer);
                    $book->setOfferId(null);
                    $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("reserved");
                    $book->setStateId($state);
                    $book->setFloorId(null);
                    $book->setUserId(null);
                    $book->setOccasionId(null);
                    $book->setCompanyId(null);
                    $book->setNoteAdmin(strip_tags($book_noteadmin));
                    $date = new \Datetime("1970-01-01 " . $book_hour);
                    $hournow = $date->format("U");
                    $interval = $date->getTimestamp();
                    $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->findBetweenInterval($interval);
                    if (!$service) $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneBy(array());
                    $book->setServiceId($service);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok"));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"error"));
    }

    /**
     * @Route("/book/add_xhr")
     */
    public function addXhrAction(Request $request)
    {
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $Book = $request->get("book");
        $Passage = $request->get("passage");
        $Customer = $request->get("customer");
        $user = $this->get('security.context')->getToken()->getUser();
        if (isset($Passage["pax"]) && !empty($Passage["pax"]) && is_numeric($Passage["pax"])) {
            $Book = $Passage;
        }
        if (empty($Customer["id"]) || !$customer = $this->getDoctrine()->getRepository("RestaurantBundle:Customer")->find($Customer["id"])) {
            $customer = new Customer();
        }
        if (empty($Customer["none"])) {
            if ($customer->getId() == "1") {
            } else {
                $customer->setSexe($Customer["sexe"]);
                $customer->setFirstName($Customer["firstname"]);
                $customer->setLastName($Customer["lastname"]);
                $customer->setEmail($Customer["email"]);
                $customer->setIndicatifMobileNumber($Customer["indicatif_mobile_number"]);
                $customer->setMobileNumber($Customer["mobile_number"]);
                if (preg_match("/^([0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4})$/", $Customer["datebirthday"])) {
                    $customer->setDateBirthday(new \DateTime($Customer["datebirthday"]));
                }
                $customer->setLangue($Customer["langue"]);
                if (isset($Customer["vip"]) && $Customer["vip"] == "1")
                    $customer->setVip(1);
                else
                    $customer->setVip(0);

                $em = $this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();
            }
        } else {
            //Select the customer passager
            $customer = $this->getDoctrine()->getRepository("RestaurantBundle:Customer")->find(1);
        }

        $offer = $this->getDoctrine()->getRepository("RestaurantBundle:Offer")->find($Book["offer"]);
        $floor = $this->getDoctrine()->getRepository("RestaurantBundle:Floor")->find($Book["floor"]);
        if (isset($Book["typebook"]) && $Book["typebook"] == "passage") {
            $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("seated");
        }else{
            if(!empty($Book["state"]) && is_numeric($Book["state"]))
                $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->find($Book["state"]);
            else
                $state = $this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("reserved");
        }
        $occasion = $this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->find($Book["occasion"]);
        $company = $this->getDoctrine()->getRepository("RestaurantBundle:Company")->find($Book["company"]);
        if (isset($Book["hour"]) && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/", $Book["hour"], $output)) {
            $Bookdate = $Book["date"] . " " . $output[2];
            $Bookservice = $output[1];
        }
        if (isset($Bookdate, $Bookservice, $Book["id"]) && !empty($Book["id"])) {
            // && $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneBy(["customerId"=>$customer,"dateBook"=>new \DateTime($Bookdate),"serviceId"=>$Bookservice])
            $book = $this->getDoctrine()->getRepository("RestaurantBundle:Book")->find($Book["id"]);
            $addOrupdate="update";
        } else {
            $book = new Book();
            $addOrupdate="add";
        }
        if (isset($Book["blocked"]) && $Book["blocked"] == "1")
            $book->setBlocked(1);
        else
            $book->setBlocked(0);

        if (isset($Book["hour"]) && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/", $Book["hour"], $output)) {
            $Book["date"] = $Book["date"] . " " . $output[2];
            $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->find($output[1]);
            if ($service) $book->setServiceId($service);
        }
        if (isset($Book["typebook"]) && $Book["typebook"] == "passage") {
            $Book["date"] = new \DateTime("");
            $time = $Book["date"]->format("H:i");
            $date = new \Datetime("1970-01-01 " . $time);
            $hournow = $date->format("U");
            $interval = $date->getTimestamp();
            $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->findBetweenInterval($interval);
            if ($service) {
                $servicevaleur = json_decode($service->getValeur());
                $openhour = $servicevaleur->Lundi->OPENHOUR;
                $closehour = $servicevaleur->Lundi->CLOSEHOUR;
                $interval = $servicevaleur->Lundi->INTERVAL;
                $openhourtimestamp = new \DateTime("1970-01-01 " . $openhour);
                $openhourtimestamp = $openhourtimestamp->format("U");
                $closehourtimestamp = new \DateTime("1970-01-01 " . $closehour);
                $closehourtimestamp = $closehourtimestamp->format("U");
                $j = 0;
                for ($i = $openhourtimestamp; $i <= $closehourtimestamp; $i = $i + $interval) {
                    if ($hournow < $i && $j == 0) {
                        $hourselected = date("H:i:s", $i);
                        $Book["date"] = $Book["date"]->format("Y-m-d") . " " . $hourselected;
                        $j++;
                    }
                }
            } else {
                $service = $this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneBy(array());
                if ($service) {
                    $servicevaleur = json_decode($service->getValeur());
                    $openhour = $servicevaleur->Lundi->OPENHOUR;
                    $openhourtimestamp = new \DateTime("1970-01-01 " . $openhour);
                    $openhourtimestamp = $openhourtimestamp->format("U");
                    $hourselected = date("H:i:s", $openhourtimestamp);
                    $Book["date"] = $Book["date"]->format("Y-m-d") . " " . $hourselected;
                } else {
                    $Book["date"] = $Book["date"]->format("Y-m-d H:i");
                }
            }
        }
        $statecolor = "";
        $stateslugify = "";
        $stateid = "";
        $orderstate = "";
        $statename = "";
        $attr = "no-attr";
        $offername = "";
        $offericon = "";
        $occasionname = "";
        $occasioncolor = "";
        $occasionicon = "";
        $floorslug="";
        if($book->getFloorId()){
            $floorslug=$book->getFloorId()->getSlug();
        }
        if (!empty($Book["pax"]) && is_numeric($Book["pax"]) && $Book["pax"] > 0) $book->setPax($Book["pax"]);
        $oldnote=$book->getNoteAdmin();
        if (!empty($Book["noteadmin"]) || (empty($Book["noteadmin"]) && !empty($oldnote))) $book->setNoteAdmin($Book["noteadmin"]);
        if (!empty($Book["date"])) $book->setDateBook(new \DateTime($Book["date"]));
        if ($customer) $book->setCustomerId($customer); else $book->setCustomerId(null);
        if ($offer){
            $book->setOfferId($offer);
            $offername = $offer->getName();
            $offericon = $offer->getIcon();
        }else $book->setOfferId(null);
        $BeginingWaitingTime="";
        if ($state) {
            if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                $BeginingWaitingTime=new \DateTime();
                $book->setBeginingWaitingTime($BeginingWaitingTime);
                $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
            }
            $book->setStateId($state);
            $stateid = $state->getId();
            $orderstate = $state->getOrderInFilter();
            $statecolor = $state->getColor();
            $servicesymfony = $this->get("get_service");
            $stateslugify = $state->getFunction();
            $statename = $state->getName();
        } else $book->setStateId(null);
        if ($floor) $book->setFloorId($floor); else $book->setFloorId(null);
        if ($user) $book->setUserId($user); else $book->setUserId(null);


        if ($occasion) {
            $book->setOccasionId($occasion);
            $occasionname = $occasion->getName();
            $occasioncolor = $occasion->getColor();
            $occasionicon = $occasion->getIcon();
        }else{
            $book->setOccasionId(null);
        }
        $companyname="-";
        if ($company){
            $companyname=$company->getName();
            $book->setCompanyId($company);
        }else $book->setCompanyId(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();
        $tablesId = "";
        $oldtabls= "";
        foreach ($book->getBooktabls() as $bt) {
            if (empty($oldtabls)) {
                $oldtabls .= $bt->getTablId()->getName();
            } else {
                $oldtabls .= '+'.$bt->getTablId()->getName();
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($bt);
            $em->flush();
        }

        $tablesarray = array();
        $newtabls="";
        if($state && $state->getFunction()!="cancelled"){/*$state->getFunction()!="free" && */
            if (!empty($Book["tables_name"])) {
                $Book["tables_name"] = trim($Book["tables_name"]);
                $Book["tables_name"] = str_replace(" ", "", $Book["tables_name"]);
                $tables = explode("+", $Book["tables_name"]);

                if ($tables) {
                    $attr = "attr";
                    foreach ($tables as $tablename) {
                        $tablename = (string)$tablename;
                        $booktable = new BookTabl();
                        $table = $this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneByName($tablename);
                        if ($table) {
                            $booktable->setBookId($book);
                            $booktable->setTablId($table);
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($booktable);
                            $em->flush();
                            $tablesarray[] = $table->getId();
                            if (empty($tablesId)) {
                                $newtabls .= $table->getName();
                                $tablesId .= '<span data-book-tablid="' . $table->getId() . '" class="booktablid">' . $table->getName() . '</span>';
                            } else {
                                $newtabls .= '+'.$table->getName();
                                $tablesId .= ' + <span data-book-tablid="' . $table->getId() . '" class="booktablid">' . $table->getName() . '</span>';
                            }
                        }
                    }
                }
            }
        }
        $message="La réservation a été modifier avec succès.";
        if($addOrupdate=="add"){
            $notif=new Notification();
            if($user) $notif->setUserId($user);
            if($book) $notif->setBookId($book);
            $message=$user->getLastName()." ".$user->getFirstName()." vient d'insérer une réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i").".";
            if(!empty($message)) $notif->setMessage($message);
            $notif->setTypeNotif("success");
            $notif->setViewed(0);
            $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
            $em=$this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();
        }else{
            if(!empty($Book["tables_name"]) && $oldtabls!=$Book["tables_name"]){
                $notif=new Notification();
                if($user) $notif->setUserId($user);
                if($book) $notif->setBookId($book);
                $message=$user->getLastName()." ".$user->getFirstName()." vient de modifier les tables du réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i")." les nouvelles tables sont : ".$Book["tables_name"];
                if(!empty($message)) $notif->setMessage($message);
                $notif->setTypeNotif("info");
                $notif->setViewed(0);
                $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                $em=$this->getDoctrine()->getManager();
                $em->persist($notif);
                $em->flush();
            }
        }

        $timestamp=$book->getDateBook()->format('U');
        $booktime=$book->getDateBook()->format('H:i');

        $response = new JsonResponse();
        return $response->setData(array(
            'reponse'=>"ok",
            'stateslugify'=>$stateslugify,
            'serviceid'=>$service->getId(),
            'timestamp'=>$timestamp,
            'bookid'=>$book->getId(),
            'bookpax'=>$book->getPax(),
            'customersexe'=>$customer->getSexe(),
            'customerfirstname'=>$customer->getFirstName(),
            'customerlastname'=>$customer->getLastName(),
            'customervip'=>$customer->getVip(),
            'offername'=>$offername,
            'offericon'=>$offericon,
            'occasionname'=>$occasionname,
            'occasioncolor'=>$occasioncolor,
            'occasionicon'=>$occasionicon,
            'companyname'=>$companyname,
            'attr'=>$attr,
            'alltables'=>$newtabls,
            'statecolor'=>$statecolor,
            'statename'=>$statename,
            'stateid'=>$stateid,
            'orderstate'=>$orderstate,
            'noteadmin'=>$book->getNoteAdmin(),
            'bookblocked'=>$book->getBlocked(),
            'booktime'=>$booktime,
            "tablesId"=>$tablesId,
            "floorslug"=>$floorslug,
            "tablesarray"=>$tablesarray,
            "dateBook"=>$book->getDateBook()->format("d-m-Y"),
            "addOrupdate"=>$addOrupdate,
            'message'=>$message,
            'BeginingWaitingTime'=>$BeginingWaitingTime,
            'status'=>'info'
        ));
    }
    public function affectTableAction(Request $request,$id,$tablid){
        $tabltoremoveid = $request->get("tabltoremoveid");

        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        $table=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($tablid);
        if(!empty($tabltoremoveid) && $tabltoremoveid>0){
            $tabletoremove=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($tabltoremoveid);
        }
        if($book && $table){
            $user = $this->get('security.context')->getToken()->getUser();
            $booktable = new BookTabl();
            $booktable->setBookId($book);
            $booktable->setTablId($table);
            $em = $this->getDoctrine()->getManager();
            $em->persist($booktable);
            $em->flush();
            if(isset($tabletoremove) && $tabletoremove){
                $bt=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findOneBy(array("bookId"=>$book,"tablId"=>$tabletoremove));
                $em=$this->getDoctrine()->getManager();
                $em->remove($bt);
                $em->flush();
            }

            $tablsToReturn="";
            $notif=new Notification();
            if($user) $notif->setUserId($user);
            if($book) $notif->setBookId($book);
            $message=$user->getLastName()." ".$user->getFirstName()." vient d'affecté la table ".$table->getName()." à la réservation numéro ".$book->getId().".";
            if(!empty($message)) $notif->setMessage($message);
            $notif->setTypeNotif("success");
            $notif->setViewed(0);
            $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
            $em=$this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();

            $booktabls=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($book);
            foreach($booktabls as $bt){
                if($bt->getTablId()){
                    if(empty($tablsToReturn)){
                        $tablsToReturn .= '<span data-book-tablid="'.$bt->getTablId()->getId().'" class="booktablid">'.$bt->getTablId()->getName().'</span>';
                    }else{
                        $tablsToReturn .= ' + <span data-book-tablid="'.$bt->getTablId()->getId().'" class="booktablid">' . $bt->getTablId()->getName().'</span>';
                    }
                }
            }


            $response = new JsonResponse();
            return $response->setData(array(
                'reponse'=>"ok",
                'message'=>$message,
                'status'=>'info',
                'tables'=>$tablsToReturn
            ));
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function getBookXhrAction($id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            $datas=array();
            $datas["id"]=$book->getId();
            $datas["date"]=$book->getDateBook()->format("d-m-Y");
            $datas["offer"]="";
            if($book->getOfferId())
            $datas["offer"]=$book->getOfferId()->getId();
            $datas["state"]="";
            if($book->getStateId())
            $datas["state"]=$book->getStateId()->getId();
            $datas["occasion"]="";
            if($book->getOccasionId())
            $datas["occasion"]=$book->getOccasionId()->getId();
            $datas["company"]="";
            if($book->getCompanyId())
            $datas["company"]=$book->getCompanyId()->getId();
            $datas["hour"]="";
            if($book->getServiceId())
            $datas["hour"]=$book->getServiceId()->getId().'|'.$book->getDateBook()->format("H\:i");
            $datas["pax"]=$book->getPax();
            if($book->getFloorId()) $datas["floor"]=$book->getFloorId()->getId();
            else $datas["floor"]="";
            $datas["blocked"]="0";
            if($book->getBlocked())
                $datas["blocked"]=1;
            $datas["note"]=$book->getNoteAdmin();
            $tablnames="";$tableids="";
            foreach($book->getBooktabls() as $bt){
                if($bt->getTablId()){
                    $tableids.=$bt->getTablId()->getId().",";
                    $tablnames.=$bt->getTablId()->getName()."+";
                }
            }
            $datas["tableids"]=(!empty($tableids))? substr($tableids,0,-1) : "";
            $datas["tablesname"]=(!empty($tablnames))? substr($tablnames,0,-1) : "";
            $customer=array();
            if($Customer=$book->getCustomerId()){
                $customer["firstname"]=$Customer->getFirstName();
                $customer["lastname"]=$Customer->getLastName();
                $customer["sexe"]=$Customer->getSexe();
                $customer["vip"]=$Customer->getVip();
                $customer["email"]=$Customer->getEmail();
                $customer["indicatif_mobile_number"]=$Customer->getIndicatifMobileNumber();
                $customer["mobile_number"]=$Customer->getMobileNumber();
                $customer["langue"]=$Customer->getLangue();
                if($Customer->getDateBirthday())
                    $customer["datebirthday"]=$Customer->getDateBirthday()->format("d-m-Y");
                else
                    $customer["datebirthday"]="";
                $customer["id"]=$Customer->getId();
            }
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","book"=>$datas,"customer"=>$customer));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
    /**
     * @Route("/book/delete_xhr/{id}")
     */
    public function deleteXhrAction($id)
    {
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            $em=$this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok"));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist"));
        }
    }
    /**
     * @Route("/book/edit_xhr/{id}")
     */
    public function editXhrAction(Request $request,$id){
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            $Book=$request->get("book");
            $Passage=$request->get("passage");
            $Customer=$request->get("customer");
            if(isset($Passage["pax"]) && !empty($Passage["pax"]) && is_numeric($Passage["pax"])){
                $Book=$Passage;
            }
            if(empty($Customer["id"]) || !$customer=$this->getDoctrine()->getRepository("RestaurantBundle:Customer")->find($Customer["id"])){
                $customer=new Customer();
            }
            $customer->setFirstName($Customer["firstname"])
                ->setLastName($Customer["lastname"])
                ->setEmail($Customer["email"])
                ->setIndicatifMobileNumber($Customer["indicatif_mobile_number"])
                ->setMobileNumber($Customer["mobile_number"])
                ->setSexe($Customer["sexe"])
                ->setDateBirthday(new \DateTime($Customer["datebirthday"]))
                ->setLangue($Customer["langue"]);
            if(isset($Customer["vip"]) && $Customer["vip"]=="1")
                $customer->setVip(1);
            else
                $customer->setVip(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();


            $offer=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->find($Book["offer"]);
            $floor=$this->getDoctrine()->getRepository("RestaurantBundle:Offer")->find($Book["floor"]);
            $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->find($Book["state"]);
            $occasion=$this->getDoctrine()->getRepository("RestaurantBundle:Occasion")->find($Book["occasion"]);
            $company=$this->getDoctrine()->getRepository("RestaurantBundle:Company")->find($Book["company"]);
            if(isset($Book["hour"]) && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/",$Book["hour"],$output)) {
                $Bookdate = $Book["date"] . " " . $output[2];
                $Bookservice=$output[1];
            }

            if(isset($Book["hour"]) && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/",$Book["hour"],$output)){
                $Book["date"]=$Book["date"]." ".$output[2];
                $service=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->find($output[1]);
                $book->setServiceId($service);
            }

            $book->setPax($Book["pax"]);
            $book->setNoteAdmin($Book["noteadmin"]);
            $book->setDateBook(new \DateTime($Book["date"]));
            $book->setCustomerId($customer);
            $book->setOfferId($offer);
            $BeginingWaitingTime="";
            if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                $BeginingWaitingTime=new \DateTime();
                $book->setBeginingWaitingTime($BeginingWaitingTime);
                $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
            }
            $book->setStateId($state);
            $book->setFloorId($floor);

            $book->setOccasionId($occasion);
            $book->setCompanyId($company);
            $em=$this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();


            foreach($book->getBooktabls() as $bt){
                $em=$this->getDoctrine()->getManager();
                $em->remove($bt);
                $em->flush();
            }
            if(isset($Book["tables_id"])){
                $tables=explode(",",$Book["tables_id"]);
                if($tables){
                    foreach($tables as $tableid){
                        $tableid=intval($tableid);
                        $booktable=new BookTabl();
                        $table=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->find($tableid);
                        $booktable->setBookId($book);
                        $booktable->setTablId($table);
                        $em=$this->getDoctrine()->getManager();
                        $em->persist($booktable);
                        $em->flush();
                    }
                }
            }
            if($book->getStateId()->getFunction()=="free"){
                foreach($book->getBooktabls() as $bt){
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($bt);
                    $em->flush();
                }
            }

            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","BeginingWaitingTime"=>$BeginingWaitingTime));
        }else{
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"notexist",'id'=>$id));
        }
    }
    /**
     * @Route("/book/calendar.json")
     */
    public function calendarAction(Request $request)
    {
        $datestart=$request->get("start");
        $dateend=$request->get("end");
        if($datestart && $dateend && preg_match("/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/",$datestart) && preg_match("/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/",$datestart) && strtotime($dateend)>=strtotime($datestart)){
            $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->Calendar($datestart,$dateend);
            return $this->render('RestaurantBundle:book:calendar.html.twig',array('books'=>$books));
        }

    }
    /**
     * @Route("/book/detail/{id}/")
     */
    public function detailAction($id){
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            $booksOfTheDay=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDateDetail($book->getDateBook(),$id);
            return $this->render('RestaurantBundle:book:detail.html.twig',compact("book","booksOfTheDay"));
        }
    }
    /**
     * @Route("/book/edit/{id}/")
     */
    public function editAction($id){
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            return $this->render('RestaurantBundle:book:edit.html.twig',compact("book"));
        }
    }

    /**
     * @Route("/updatehour/{id}")
     */
    public function updateHourXHRAction(Request $request,$id){
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        $ServiceHour=$request->get("servicehour");
        if($book && preg_match("/^([0-9]+)\|([0-9]{1,2}\:[0-9]{1,2})$/", $ServiceHour, $output)){
            $service=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($output[1]);
            if($service){
                $datebook=new \Datetime($book->getDateBook()->format("Y-m-d")." ".$output[2]);
                $book->setDateBook($datebook);
                $book->setServiceId($service);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","hour"=>$output[2],"service"=>$output[1]));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist",'id'=>$id));
    }

    /**
     * @Route("/updatetables/{id}")
     */
    public function updateTablesXHRAction(Request $request,$id){
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        $selectedtabls=$request->get("selectedtabls");
        if($book && preg_match("/^(([\ ]+)?)((\d+)(([\ ]+)?)((\+)?)(([\ ]+)?))+$/",$selectedtabls)){
            foreach ($book->getBooktabls() as $bt) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($bt);
                $em->flush();
            }
            $tablesToReturn="";
            $tablesexist=array();
            $selectedtabls = trim($selectedtabls);
            $selectedtabls = str_replace(" ", "", $selectedtabls);
            $tables = explode("+", $selectedtabls);
            if ($tables) {
                foreach ($tables as $tablename) {
                    $tablename = (string)$tablename;
                    $booktable = new BookTabl();
                    $table = $this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneByName($tablename);
                    if ($table) {
                        //Search if table is available
                        $searchtabl=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->SearchForDuplicata($table,$book);
                        if(!$searchtabl) {
                            $booktable->setBookId($book);
                            $booktable->setTablId($table);
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($booktable);
                            $em->flush();

                            if (empty($tablesToReturn)) {
                                $tablesToReturn .= $table->getName();
                            } else {
                                $tablesToReturn .= '+' . $table->getName();
                            }
                        }else{
                            $tablesexist[]=$table->getName();
                        }
                    }
                }
                if(empty($tablesexist)){
                    $response = new JsonResponse();
                    return $response->setData(array('reponse'=>"ok","tables"=>$tablesToReturn));
                }else{
                    $response = new JsonResponse();
                    return $response->setData(array('reponse'=>"okbutsomeexist","tables"=>$tablesToReturn,"existtables"=>implode($tablesexist," , ")));
                }
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist",'id'=>$id));
    }
    /**
     * @Route("/updatetables/{id}")
     */
    public function verifyTablesXHRAction(Request $request){
        $selectedtabls=$request->get("selectedtabls");
        $bookid=$request->get("bookid");
        $date=$request->get("date");
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($bookid);
        if(($book || !empty($date)) && preg_match("/^(([\ ]+)?)((\d+)(([\ ]+)?)((\+)?)(([\ ]+)?))+$/",$selectedtabls)){
            $tablesToReturn="";
            $tablesexist=array();
            $selectedtabls = trim($selectedtabls);
            $selectedtabls = str_replace(" ", "", $selectedtabls);
            $tables = explode("+", $selectedtabls);
            $blocked=array();
            $toomanytables=false;
            if ($tables) {
                foreach ($tables as $tablename) {
                    $tablename = (string)$tablename;
                    $table = $this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneByName($tablename);
                    if ($table) {
                        //Search if table is available
                        if($book){
                            $searchtabl=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->SearchForDuplicataWithDateAndBook($table,$date,$book);
                        }else if(!empty($date)){
                            $searchtabl=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->SearchForDuplicataWithDate($table,$date);
                        }
                        if(!$searchtabl) {

                            if (empty($tablesToReturn)) {
                                $tablesToReturn .= $table->getName();
                            } else {
                                $tablesToReturn .= '+' . $table->getName();
                            }
                        }else{
                            $tablesexist[]=$table->getName();
                            $i=0;
                            foreach($searchtabl as $s){
                                if($s->getBookId()){
                                    $blocked[$table->getId()]=array("name"=>$table->getName(),"blocked"=>$s->getBookId()->getBlocked());
                                    $i++;
                                }
                            }
                            if($i>1){
                                $toomanytables=true;
                            }
                        }
                    }
                }
                if(empty($tablesexist)){
                    $response = new JsonResponse();
                    return $response->setData(array('reponse'=>"ok","tables"=>$tablesToReturn));
                }else{
                    $response = new JsonResponse();
                    return $response->setData(array('reponse'=>"okbutsomeexist","tables"=>$tablesToReturn,"existtables"=>implode($tablesexist," , "),"blocked"=>$blocked,"toomanytables"=>$toomanytables));
                }
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }

    public function changeBookTablesXHRAction(Request $request){
        $bookid=$request->get("bookid");
        $tableid=$request->get("tableid");
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($bookid);
        $table=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($tableid);
        $tablesToReturn="";$otherTablsToReturn="";$otherbook=false;$otherbookid="";
        if(!$book && $table){
            $date=$request->get("date");
            if(!empty($date)){
                $searchtabl=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->SearchForDuplicataWithDate($table,$date);
                foreach($searchtabl as $s){
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($s);
                    $em->flush();
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"okdate","tableid"=>$table->getId(),"tablename"=>$table->getName()));
            }
        }else if($book && $table) {
            if(!$book->getBlocked()){
                $searchtabl=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->SearchForDuplicataWithDateAndBook($table,$book->getDateBook()->format("Y-m-d H:i:s"),$book);
                foreach($searchtabl as $s){
                    $otherbook=$s->getBookid();
                    $em=$this->getDoctrine()->getManager();
                    $em->remove($s);
                    $em->flush();
                }
                $book_table=new BookTabl();
                $book_table->setBookId($book);
                $book_table->setTablId($table);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book_table);
                $em->flush();
                $booktabls=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($book);
                foreach($booktabls as $bt){
                    if($bt->getTablId()){
                        if(empty($tablesToReturn)){
                            $tablesToReturn .= $bt->getTablId()->getName();
                        }else{
                            $tablesToReturn .= '+' . $bt->getTablId()->getName();
                        }
                    }
                }
                if($otherbook){
                    $otherbooktabls=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($otherbook);
                    foreach($otherbooktabls as $bt){
                        if($bt->getTablId()){
                            $otherbookid=$bt->getBookId()->getId();
                            if(empty($otherTablsToReturn)){
                                $otherTablsToReturn .= $bt->getTablId()->getName();
                            }else{
                                $otherTablsToReturn .= '+' . $bt->getTablId()->getName();
                            }
                        }
                    }
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","bookid"=>$book->getId(),"tableid"=>$table->getId(),"otherbookid"=>$otherbookid,"tables"=>$tablesToReturn,"othertables"=>$otherTablsToReturn));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function switchBookTablesXHRAction(Request $request){
        $bookid1=$request->get("bookid1");
        $tableid1=$request->get("tableid1");
        $bookid2=$request->get("bookid2");
        $tableid2=$request->get("tableid2");
        $book1=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($bookid1);
        $book2=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($bookid2);
        $table1=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($tableid1);
        $table2=$this->getDoctrine()->getRepository("RestaurantBundle:Tabl")->findOneById($tableid2);
        $tablesToReturn1="";$otherTablsToReturn1="";$otherbook1=false;$otherbookid1="";
        $tablesToReturn2="";$otherTablsToReturn2="";$otherbook2=false;$otherbookid2="";
        if($book1 && $table1 && $book2 && $table2) {
            if(!$book1->getBlocked() && !$book2->getBlocked()){

                foreach($book1->getBooktabls() as $bt){
                    if($bt->getTablId()->getId()==$table1->getId()){
                        $em=$this->getDoctrine()->getManager();
                        $em->remove($bt);
                        $em->flush();
                    }
                }
                foreach($book2->getBooktabls() as $bt){
                    if($bt->getTablId()->getId()==$table2->getId()){
                        $em=$this->getDoctrine()->getManager();
                        $em->remove($bt);
                        $em->flush();
                    }
                }
                $book_table1=new BookTabl();
                $book_table1->setBookId($book1);
                $book_table1->setTablId($table2);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book_table1);
                $em->flush();
                $book_table2=new BookTabl();
                $book_table2->setBookId($book2);
                $book_table2->setTablId($table1);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book_table2);
                $em->flush();
                $booktabls1=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($book1);
                foreach($booktabls1 as $bt){
                    if($bt->getTablId()){
                        if(empty($tablesToReturn)){
                            $tablesToReturn1 .= '<span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                        }else{
                            $tablesToReturn1 .= ' + <span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                        }
                    }
                }
                $booktabls2=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($book2);
                foreach($booktabls2 as $bt){
                    if($bt->getTablId()){
                        if(empty($tablesToReturn)){
                            $tablesToReturn2 .= '<span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                        }else{
                            $tablesToReturn2 .= ' + <span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                        }
                    }
                }
                if($otherbook1){
                    $otherbooktabls1=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($otherbook1);
                    foreach($otherbooktabls1 as $bt){
                        if($bt->getTablId()){
                            $otherbookid=$bt->getBookId()->getId();
                            if(empty($otherTablsToReturn)){
                                $otherTablsToReturn1 .= '<span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                            }else{
                                $otherTablsToReturn1 .= ' + <span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                            }
                        }
                    }
                }
                if($otherbook2){
                    $otherbooktabls2=$this->getDoctrine()->getRepository("RestaurantBundle:BookTabl")->findByBookId($otherbook2);
                    foreach($otherbooktabls2 as $bt){
                        if($bt->getTablId()){
                            $otherbookid=$bt->getBookId()->getId();
                            if(empty($otherTablsToReturn)){
                                $otherTablsToReturn2 .= '<span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                            }else{
                                $otherTablsToReturn2 .= ' + <span data-book-tablid="' . $bt->getTablId()->getId() . '" class="booktablid">' . $bt->getTablId()->getName() . '</span>';
                            }
                        }
                    }
                }
                $state1="";$state2="";
                if($book1->getStateId()){
                    $state1=$book1->getStateId()->getColor();
                }
                if($book2->getStateId()){
                    $state2=$book2->getStateId()->getColor();
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","bookid1"=>$book1->getId(),"tableid1"=>$table1->getId(),"otherbookid1"=>$otherbookid1,"tables1"=>$tablesToReturn1,"othertables1"=>$otherTablsToReturn1,"state1"=>"md-bg-".$state1,"bookid2"=>$book2->getId(),"tableid2"=>$table2->getId(),"otherbookid2"=>$otherbookid2,"tables2"=>$tablesToReturn2,"othertables2"=>$otherTablsToReturn2,"state2"=>"md-bg-".$state2));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    /**
     * @Route("/verifyfreetables/{date}")
     */
    public function verifyFreeTablesXHRAction(Request $request,$date){
        if(!empty($date)){
            $busytables=array();
            $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDate($date);
            foreach($books as $book){
                if($book->getBooktabls()){
                    if($book->getBooktabls()->getTablId()){
                        if($book->getBooktabls()->getTablId()->getId()){
                            $busytables[]=$book->getBooktabls()->getTablId()->getId();
                        }
                    }
                }
            }
            $response = new JsonResponse();
            return $response->setData(array('reponse'=>"ok","busytables"=>$busytables));
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    /**
     * @Route("/updatepax/{id}")
     */
    public function updatePaxXHRAction(Request $request,$id){
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        $pax=$request->get("pax");
        if($book && !empty($pax) && is_numeric($pax)){
            if($pax>0){
                $book->setPax($pax);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();
                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"ok","pax"=>$pax));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist",'id'=>$id));
    }

    public function confirmBookEmailAction(Request $request,$id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            if($book->getCustomerId()){
                $state=$this->getDoctrine()->getRepository('RestaurantBundle:State')->findOneByFunction("reserved");
                $BeginingWaitingTime="";
                if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                    $BeginingWaitingTime=new \DateTime();
                    $book->setBeginingWaitingTime($BeginingWaitingTime);
                    $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                }
                $book->setStateId($state);
                $em=$this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Confirmation de votre réservation')
                    ->setFrom('resa@comptoirdarna.com')
                    ->setTo($book->getCustomerId()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'RestaurantBundle:emails:confirm.html.twig',
                            compact('book')
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);

                $user = $this->get('security.context')->getToken()->getUser();
                $notif=new Notification();
                if($user) $notif->setUserId($user);
                if($book) $notif->setBookId($book);
                $message=$user->getLastName()." ".$user->getFirstName()." vient d'envoyé un message par email à ".$book->getCustomerId()->getSexe()." ".$book->getCustomerId()->getLastName()." ".$book->getCustomerId()->getFirstName()." pour notifier que sa réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i")." a été confirmé.";
                if(!empty($message)) $notif->setMessage($message);
                $notif->setTypeNotif("success");
                $notif->setViewed(0);
                $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                $em=$this->getDoctrine()->getManager();
                $em->persist($notif);
                $em->flush();

                $response = new JsonResponse();
                return $response->setData(array('reponse'=>"sent","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"state"=>$state->getId(),"class"=>$state->getColor(),"statename"=>$state->getName()));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function cancelBookEmailAction(Request $request,$id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            if($book->getCustomerId()){
                $state=$this->getDoctrine()->getRepository('RestaurantBundle:State')->findOneByFunction("cancelled");
                if($state){
                    $BeginingWaitingTime="";
                    if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                        $BeginingWaitingTime=new \DateTime();
                        $book->setBeginingWaitingTime($BeginingWaitingTime);
                        $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                    }
                    $book->setStateId($state);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Votre réservation a été annulée')
                        ->setFrom('resa@comptoirdarna.com')
                        ->setTo($book->getCustomerId()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'RestaurantBundle:emails:cancel.html.twig',
                                compact('book')
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);

                    $user = $this->get('security.context')->getToken()->getUser();
                    $notif=new Notification();
                    if($user) $notif->setUserId($user);
                    if($book) $notif->setBookId($book);
                    $message=$user->getLastName()." ".$user->getFirstName()." vient d'envoyé un message par email à ".$book->getCustomerId()->getSexe()." ".$book->getCustomerId()->getLastName()." ".$book->getCustomerId()->getFirstName()." pour notifier que sa réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i")." a été annulé.";
                    if(!empty($message)) $notif->setMessage($message);
                    $notif->setTypeNotif("danger");
                    $notif->setViewed(0);
                    $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($notif);
                    $em->flush();

                    $response = new JsonResponse();
                    return $response->setData(array('reponse'=>"ok","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"state"=>$state->getId(),"class"=>$state->getColor(),"statename"=>$state->getName()));
                }
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function pendingBookEmailAction(Request $request,$id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book){
            if($book->getCustomerId()){
                $state=$this->getDoctrine()->getRepository('RestaurantBundle:State')->findOneByFunction("pending");
                if($state){
                    $BeginingWaitingTime="";
                    if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                        $BeginingWaitingTime=new \DateTime();
                        $book->setBeginingWaitingTime($BeginingWaitingTime);
                        $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                    }
                    $book->setStateId($state);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Votre table est prête')
                        ->setFrom('resa@comptoirdarna.com')
                        ->setTo($book->getCustomerId()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'RestaurantBundle:emails:tableready.html.twig',
                                compact('book')
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);

                    $user = $this->get('security.context')->getToken()->getUser();
                    $notif=new Notification();
                    if($user) $notif->setUserId($user);
                    if($book) $notif->setBookId($book);
                    $message=$user->getLastName()." ".$user->getFirstName()." vient d'envoyé un message par email à ".$book->getCustomerId()->getSexe()." ".$book->getCustomerId()->getLastName()." ".$book->getCustomerId()->getFirstName()." pour notifier que sa réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i")." est mis en attente.";
                    if(!empty($message)) $notif->setMessage($message);
                    $notif->setTypeNotif("warning");
                    $notif->setViewed(0);
                    $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($notif);
                    $em->flush();

                    $response = new JsonResponse();
                    return $response->setData(array('reponse'=>"ok","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"state"=>$state->getId(),"class"=>$state->getColor(),"statename"=>$state->getName()));
                }
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function confirmBookWhatsappAction(Request $request,$id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book) {
            if ($book->getCustomerId()) {
                if (preg_match("/^\+([0-9]+)$/", $book->getCustomerId()->getIndicatifMobileNumber()) && !empty($book->getCustomerId()->getMobileNumber())) {
                    $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("reserved");
                    $BeginingWaitingTime="";
                    if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                        $BeginingWaitingTime=new \DateTime();
                        $book->setBeginingWaitingTime($BeginingWaitingTime);
                        $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                    }
                    $book->setStateId($state);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                    $TARGETINDICATIF = str_replace("+", "", $book->getCustomerId()->getIndicatifMobileNumber());
                    $TARGETPHONE = trim($book->getCustomerId()->getMobileNumber());
                    $TARGETPHONE = str_replace(array("-", ",", ".", " ", "_"), "", $TARGETPHONE);
                    $TARGETPHONE = intval($TARGETPHONE);
                    $TARGET = $TARGETINDICATIF . $TARGETPHONE;
                    $SITECONFIG = array("SITENAME", "WHATSAPPNUMBER","WHATSAPPCHATNUMBER", "WHATSAPPPASSWORD", "WHATSAPPCONFIRM", "WHATSAPPPENDING", "WHATSAPPLATITUDE", "WHATSAPPLONGITUDE");
                    foreach ($SITECONFIG as $v) {
                        ${$v} = $this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName($v);
                        if (${$v}) {
                            ${$v} = ${$v}->getValue();
                        } else {
                            ${$v} = "";
                        }
                    }
                    $message = $WHATSAPPCONFIRM;
                    $CUSTOMERCIVILITY = "";
                    $CUSTOMERFIRSTNAME = "";
                    $CUSTOMERLASTNAME = "";
                    $CUSTOMEREMAIL = "";
                    $CUSTOMERPHONE = "";

                    $CUSTOMERCIVILITY = $book->getCustomerId()->getSexe();
                    $CUSTOMERFIRSTNAME = $book->getCustomerId()->getFirstName();
                    $CUSTOMERLASTNAME = $book->getCustomerId()->getLastName();
                    $CUSTOMEREMAIL = $book->getCustomerId()->getEmail();
                    $CUSTOMERPHONE = $book->getCustomerId()->getMobileNumber();

                    $BOOKNUMBER = $book->getId();
                    $BOOKTABLES = "";
                    $BOOKDATE = $book->getDateBook()->format("j F, Y");
                    $BOOKTIME = $book->getDateBook()->format("H\:i");
                    $BOOKPAX = $book->getPax();

                    if ($book->getBooktabls()) {
                        foreach ($book->getBooktabls() as $bt) {
                            if ($bt->getTablId()) {
                                if (empty($BOOKTABLES)) {
                                    $BOOKTABLES .= $bt->getTablId()->getName();
                                } else {
                                    $BOOKTABLES .= '+' . $bt->getTablId()->getName();
                                }
                            }
                        }
                    }
                    $BOOKFLOOR = "";
                    if ($book->getFloorId()) {
                        $BOOKFLOOR = $book->getFloorId()->getName();
                    }
                    $RESTAURANTNAME = $SITENAME;

                    $message = str_replace("[#CUSTOMERCIVILITY#]", $CUSTOMERCIVILITY, $message);
                    $message = str_replace("[#CUSTOMERFIRSTNAME#]", $CUSTOMERFIRSTNAME, $message);
                    $message = str_replace("[#CUSTOMERLASTNAME#]", $CUSTOMERLASTNAME, $message);
                    $message = str_replace("[#CUSTOMEREMAIL#]", $CUSTOMEREMAIL, $message);
                    $message = str_replace("[#CUSTOMERPHONE#]", $CUSTOMERPHONE, $message);
                    $message = str_replace("[#BOOKNUMBER#]", $BOOKNUMBER, $message);
                    $message = str_replace("[#BOOKTABLES#]", $BOOKTABLES, $message);
                    $message = str_replace("[#BOOKDATE#]", $BOOKDATE, $message);
                    $message = str_replace("[#BOOKTIME#]", $BOOKTIME, $message);
                    $message = str_replace("[#BOOKPAX#]", $BOOKPAX, $message);
                    $message = str_replace("[#BOOKFLOOR#]", $BOOKFLOOR, $message);
                    $message = str_replace("[#RESTAURANTNAME#]", $RESTAURANTNAME, $message);

                    $w = new WhatsProt($WHATSAPPNUMBER, $SITENAME, false);
                    $w->setMessageStore(new SqliteMessageStore($WHATSAPPNUMBER));
                    $w->connect();
                    $w->loginWithPassword($WHATSAPPPASSWORD);
                    $w->sendSync(array($TARGET));
                    $w->sendPresenceSubscription($TARGET);
                    $w->sendSetProfilePicture("http://localhost/restaurant/web/images/whatsapp.jpg");//$request->getUriForPath('/images/whatsapp.jpg')
                    $w->sendGetProfilePicture($TARGET, true);
                    $w->sendMessageComposing($TARGET);
                    sleep(2);
                    $w->sendMessagePaused($TARGET);
                    $w->sendMessage($TARGET, $message);
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $v = new vCard();
                    $v->set('data', array(
                        'first_name' => 'Comptoir',
                        'last_name' => 'Darna',
                        'cell_tel' => $WHATSAPPCHATNUMBER,
                    ));
                    $w->sendVcard($TARGET, $SITENAME, $v->show());
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $w->sendMessageLocation($TARGET, $WHATSAPPLONGITUDE, $WHATSAPPLATITUDE);
                    while ($w->pollMessage()) ;
                    $user = $this->get('security.context')->getToken()->getUser();
                    $notif=new Notification();
                    if($user) $notif->setUserId($user);
                    if($book) $notif->setBookId($book);
                    $message=$user->getLastName()." ".$user->getFirstName()." vient d'envoyé un message par whatsapp à ".$CUSTOMERCIVILITY." ".$CUSTOMERLASTNAME." ".$CUSTOMERFIRSTNAME." pour confirmer sa réservation pour le ".$book->getDateBook()->format("d, F Y \à H\:i").".";
                    if(!empty($message)) $notif->setMessage($message);
                    $notif->setTypeNotif("info");
                    $notif->setViewed(0);
                    $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($notif);
                    $em->flush();
                    $response = new JsonResponse();
                    return $response->setData(array('reponse' => "sent","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"state"=>$state->getId(),"class"=>$state->getColor(),"statename"=>$state->getName()));
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse' => "phoneformat"));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function afterPendingBookWhatsappAction(Request $request,$id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book) {
            if ($book->getCustomerId()) {
                if (preg_match("/^\+([0-9]+)$/", $book->getCustomerId()->getIndicatifMobileNumber()) && !empty($book->getCustomerId()->getMobileNumber())) {
                    $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("reserved");
                    $BeginingWaitingTime="";
                    if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                        $BeginingWaitingTime=new \DateTime();
                        $book->setBeginingWaitingTime($BeginingWaitingTime);
                        $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                    }
                    $book->setStateId($state);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                    $TARGETINDICATIF = str_replace("+", "", $book->getCustomerId()->getIndicatifMobileNumber());
                    $TARGETPHONE = trim($book->getCustomerId()->getMobileNumber());
                    $TARGETPHONE = str_replace(array("-", ",", ".", " ", "_"), "", $TARGETPHONE);
                    $TARGETPHONE = intval($TARGETPHONE);
                    $TARGET = $TARGETINDICATIF . $TARGETPHONE;
                    $SITECONFIG = array("SITENAME", "WHATSAPPNUMBER", "WHATSAPPCHATNUMBER", "WHATSAPPPASSWORD", "WHATSAPPPENDING", "WHATSAPPLATITUDE", "WHATSAPPLONGITUDE");
                    foreach ($SITECONFIG as $v) {
                        ${$v} = $this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName($v);
                        if (${$v}) {
                            ${$v} = ${$v}->getValue();
                        } else {
                            ${$v} = "";
                        }
                    }
                    $message = $WHATSAPPPENDING;
                    $CUSTOMERCIVILITY = "";
                    $CUSTOMERFIRSTNAME = "";
                    $CUSTOMERLASTNAME = "";
                    $CUSTOMEREMAIL = "";
                    $CUSTOMERPHONE = "";

                    $CUSTOMERCIVILITY = $book->getCustomerId()->getSexe();
                    $CUSTOMERFIRSTNAME = $book->getCustomerId()->getFirstName();
                    $CUSTOMERLASTNAME = $book->getCustomerId()->getLastName();
                    $CUSTOMEREMAIL = $book->getCustomerId()->getEmail();
                    $CUSTOMERPHONE = $book->getCustomerId()->getMobileNumber();

                    $BOOKNUMBER = $book->getId();
                    $BOOKTABLES = "";
                    $BOOKDATE = $book->getDateBook()->format("j F, Y");
                    $BOOKTIME = $book->getDateBook()->format("H\:i");
                    $BOOKPAX = $book->getPax();
                    $BOOKTABLES = "";
                    if ($book->getBooktabls()) {
                        foreach ($book->getBooktabls() as $bt) {
                            if ($bt->getTablId()) {
                                if (empty($BOOKTABLES)) {
                                    $BOOKTABLES .= $bt->getTablId()->getName();
                                } else {
                                    $BOOKTABLES .= '+' . $bt->getTablId()->getName();
                                }
                            }
                        }
                    }
                    $BOOKFLOOR = "";
                    if ($book->getFloorId()) {
                        $BOOKFLOOR = $book->getFloorId()->getName();
                    }
                    $RESTAURANTNAME = $SITENAME;

                    $message = str_replace("[#CUSTOMERCIVILITY#]", $CUSTOMERCIVILITY, $message);
                    $message = str_replace("[#CUSTOMERFIRSTNAME#]", $CUSTOMERFIRSTNAME, $message);
                    $message = str_replace("[#CUSTOMERLASTNAME#]", $CUSTOMERLASTNAME, $message);
                    $message = str_replace("[#CUSTOMEREMAIL#]", $CUSTOMEREMAIL, $message);
                    $message = str_replace("[#CUSTOMERPHONE#]", $CUSTOMERPHONE, $message);
                    $message = str_replace("[#BOOKNUMBER#]", $BOOKNUMBER, $message);
                    $message = str_replace("[#BOOKTABLES#]", $BOOKTABLES, $message);
                    $message = str_replace("[#BOOKDATE#]", $BOOKDATE, $message);
                    $message = str_replace("[#BOOKTIME#]", $BOOKTIME, $message);
                    $message = str_replace("[#BOOKPAX#]", $BOOKPAX, $message);
                    $message = str_replace("[#BOOKFLOOR#]", $BOOKFLOOR, $message);
                    $message = str_replace("[#RESTAURANTNAME#]", $RESTAURANTNAME, $message);

                    $w = new WhatsProt($WHATSAPPNUMBER, $SITENAME, false);
                    $w->setMessageStore(new SqliteMessageStore($WHATSAPPNUMBER));
                    $w->connect();
                    $w->loginWithPassword($WHATSAPPPASSWORD);
                    $w->sendSync(array($TARGET));
                    $w->sendPresenceSubscription($TARGET);
                    $w->sendSetProfilePicture("http://localhost/restaurant/web/images/whatsapp.jpg");//$request->getUriForPath('/images/whatsapp.jpg')
                    $w->sendGetProfilePicture($TARGET, true);
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $w->sendMessage($TARGET, $message);
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $v = new vCard();
                    $v->set('data', array(
                        'first_name' => 'Comptoir',
                        'last_name' => 'Darna',
                        'cell_tel' => $WHATSAPPCHATNUMBER,
                    ));
                    $w->sendVcard($TARGET, $SITENAME, $v->show());
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $w->sendMessageLocation($TARGET, $WHATSAPPLONGITUDE, $WHATSAPPLATITUDE);
                    while ($w->pollMessage()) ;
                    $user = $this->get('security.context')->getToken()->getUser();
                    $notif=new Notification();
                    if($user) $notif->setUserId($user);
                    if($book) $notif->setBookId($book);
                    $message=$user->getLastName()." ".$user->getFirstName()." vient d'envoyé un message par whatsapp à ".$CUSTOMERCIVILITY." ".$CUSTOMERLASTNAME." ".$CUSTOMERFIRSTNAME." pour le notifier que les tables sont libre.";
                    if(!empty($message)) $notif->setMessage($message);
                    $notif->setTypeNotif("info");
                    $notif->setViewed(0);
                    $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($notif);
                    $em->flush();
                    $response = new JsonResponse();
                    return $response->setData(array('reponse' => "sent","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"state"=>$state->getId(),"class"=>$state->getColor(),"statename"=>$state->getName()));
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse' => "phoneformat"));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function cancelBookWhatsappAction(Request $request,$id){
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book) {
            if ($book->getCustomerId()) {
                if (preg_match("/^\+([0-9]+)$/", $book->getCustomerId()->getIndicatifMobileNumber()) && !empty($book->getCustomerId()->getMobileNumber())) {
                    $state=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findOneByFunction("cancelled");
                    $BeginingWaitingTime="";
                    if($state->getFunction()=="pending" && (!$book->getStateId() || $state->getId()!=$book->getStateId()->getId())){
                        $BeginingWaitingTime=new \DateTime();
                        $book->setBeginingWaitingTime($BeginingWaitingTime);
                        $BeginingWaitingTime=$BeginingWaitingTime->format("Y-m-d H:i:s");
                    }
                    $book->setStateId($state);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($book);
                    $em->flush();
                    $TARGETINDICATIF = str_replace("+", "", $book->getCustomerId()->getIndicatifMobileNumber());
                    $TARGETPHONE = trim($book->getCustomerId()->getMobileNumber());
                    $TARGETPHONE = str_replace(array("-", ",", ".", " ", "_"), "", $TARGETPHONE);
                    $TARGETPHONE = intval($TARGETPHONE);
                    $TARGET = $TARGETINDICATIF . $TARGETPHONE;
                    $SITECONFIG = array("SITENAME", "WHATSAPPNUMBER", "WHATSAPPCHATNUMBER", "WHATSAPPPASSWORD", "WHATSAPPCANCEL", "WHATSAPPLATITUDE", "WHATSAPPLONGITUDE");
                    foreach ($SITECONFIG as $v) {
                        ${$v} = $this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName($v);
                        if (${$v}) {
                            ${$v} = ${$v}->getValue();
                        } else {
                            ${$v} = "";
                        }
                    }
                    $message = $WHATSAPPCANCEL;
                    $CUSTOMERCIVILITY = "";
                    $CUSTOMERFIRSTNAME = "";
                    $CUSTOMERLASTNAME = "";
                    $CUSTOMEREMAIL = "";
                    $CUSTOMERPHONE = "";

                    $CUSTOMERCIVILITY = $book->getCustomerId()->getSexe();
                    $CUSTOMERFIRSTNAME = $book->getCustomerId()->getFirstName();
                    $CUSTOMERLASTNAME = $book->getCustomerId()->getLastName();
                    $CUSTOMEREMAIL = $book->getCustomerId()->getEmail();
                    $CUSTOMERPHONE = $book->getCustomerId()->getMobileNumber();

                    $BOOKNUMBER = $book->getId();
                    $BOOKTABLES = "";
                    $BOOKDATE = $book->getDateBook()->format("j F, Y");
                    $BOOKTIME = $book->getDateBook()->format("H\:i");
                    $BOOKPAX = $book->getPax();
                    $BOOKTABLES = "";
                    if ($book->getBooktabls()) {
                        foreach ($book->getBooktabls() as $bt) {
                            if ($bt->getTablId()) {
                                if (empty($BOOKTABLES)) {
                                    $BOOKTABLES .= $bt->getTablId()->getName();
                                } else {
                                    $BOOKTABLES .= '+' . $bt->getTablId()->getName();
                                }
                            }
                        }
                    }
                    $BOOKFLOOR = "";
                    if ($book->getFloorId()) {
                        $BOOKFLOOR = $book->getFloorId()->getName();
                    }
                    $RESTAURANTNAME = $SITENAME;

                    $message = str_replace("[#CUSTOMERCIVILITY#]", $CUSTOMERCIVILITY, $message);
                    $message = str_replace("[#CUSTOMERFIRSTNAME#]", $CUSTOMERFIRSTNAME, $message);
                    $message = str_replace("[#CUSTOMERLASTNAME#]", $CUSTOMERLASTNAME, $message);
                    $message = str_replace("[#CUSTOMEREMAIL#]", $CUSTOMEREMAIL, $message);
                    $message = str_replace("[#CUSTOMERPHONE#]", $CUSTOMERPHONE, $message);
                    $message = str_replace("[#BOOKNUMBER#]", $BOOKNUMBER, $message);
                    $message = str_replace("[#BOOKTABLES#]", $BOOKTABLES, $message);
                    $message = str_replace("[#BOOKDATE#]", $BOOKDATE, $message);
                    $message = str_replace("[#BOOKTIME#]", $BOOKTIME, $message);
                    $message = str_replace("[#BOOKPAX#]", $BOOKPAX, $message);
                    $message = str_replace("[#BOOKFLOOR#]", $BOOKFLOOR, $message);
                    $message = str_replace("[#RESTAURANTNAME#]", $RESTAURANTNAME, $message);

                    $w = new WhatsProt($WHATSAPPNUMBER, $SITENAME, false);
                    $w->setMessageStore(new SqliteMessageStore($WHATSAPPNUMBER));
                    $w->connect();
                    $w->loginWithPassword($WHATSAPPPASSWORD);
                    $w->sendSync(array($TARGET));
                    $w->sendPresenceSubscription($TARGET);
                    $w->sendSetProfilePicture("http://localhost/restaurant/web/images/whatsapp.jpg");//$request->getUriForPath('/images/whatsapp.jpg')
                    $w->sendGetProfilePicture($TARGET, true);
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $w->sendMessage($TARGET, $message);
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $v = new vCard();
                    $v->set('data', array(
                        'first_name' => 'Comptoir',
                        'last_name' => 'Darna',
                        'cell_tel' => $WHATSAPPCHATNUMBER,
                    ));
                    $w->sendVcard($TARGET, $SITENAME, $v->show());
                    $w->sendMessageComposing($TARGET);
                    sleep(1);
                    $w->sendMessagePaused($TARGET);
                    $w->sendMessageLocation($TARGET, $WHATSAPPLONGITUDE, $WHATSAPPLATITUDE);
                    while ($w->pollMessage()) ;
                    $user = $this->get('security.context')->getToken()->getUser();
                    $notif=new Notification();
                    if($user) $notif->setUserId($user);
                    if($book) $notif->setBookId($book);
                    $message=$user->getLastName()." ".$user->getFirstName()." vient d'annulé par whatsapp la réservation de ".$CUSTOMERCIVILITY." ".$CUSTOMERLASTNAME." ".$CUSTOMERFIRSTNAME.".";
                    if(!empty($message)) $notif->setMessage($message);
                    $notif->setTypeNotif("info");
                    $notif->setViewed(0);
                    $notif->setGuid($this->generateUrl('book_detail', array('id' => $book->getId())));
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($notif);
                    $em->flush();
                    $response = new JsonResponse();
                    return $response->setData(array('reponse' => "sent","message"=>$message,"BeginingWaitingTime"=>$BeginingWaitingTime,"state"=>$state->getId(),"class"=>$state->getColor(),"statename"=>$state->getName()));
                }
                $response = new JsonResponse();
                return $response->setData(array('reponse' => "phoneformat"));
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"notexist"));
    }
    public function getMessagesBookWhatsappAction(Request $request){
        /*$book=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findOneById($id);
        if($book) {
            if ($book->getCustomerId()) {
                if (preg_match("/^\+([0-9]+)$/", $book->getCustomerId()->getIndicatifMobileNumber()) && !empty($book->getCustomerId()->getMobileNumber())) {
                    $TARGETINDICATIF = str_replace("+", "", $book->getCustomerId()->getIndicatifMobileNumber());
                    $TARGETPHONE = trim($book->getCustomerId()->getMobileNumber());
                    $TARGETPHONE = str_replace(array("-", ",", ".", " ", "_"), "", $TARGETPHONE);
                    $TARGETPHONE = intval($TARGETPHONE);
                    $TARGET = $TARGETINDICATIF . $TARGETPHONE;*/
                    $SITECONFIG = array("SITENAME", "WHATSAPPNUMBER", "WHATSAPPPASSWORD");
                    foreach ($SITECONFIG as $v) {
                        ${$v} = $this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName($v);
                        if (${$v}) {
                            ${$v} = ${$v}->getValue();
                        } else {
                            ${$v} = "";
                        }
                    }
                    $w = new WhatsProt($WHATSAPPNUMBER, $SITENAME, false);
                    $w->setMessageStore(new SqliteMessageStore($WHATSAPPNUMBER));
                    $w->eventManager()->bind("onGetMessage", array("WhatsappBundle\Events\MyEvents", "onGetMessage"));
                    $w->connect();
                    $w->loginWithPassword($WHATSAPPPASSWORD);
                    for ($i = 0; $i < 10; $i++) {
                        $w->pollMessage();
                    }
                    foreach($w->getMessages() as $message){
                        $from = $message->getAttribute("from");
                        $id = $message->getAttribute("id");
                        $messagebody ="";
                        if($message->getChild("body"))
                        {
                            $messagebody = $message->getChild("body")->getData();
                        }
                        echo $from."<br>".$id."<br>".$messagebody."<br>";
                    }
                    $response = new JsonResponse();
                    return $response->setData(array('reponse' => "sync"));
                /*}
            }
        }*/
    }
}
