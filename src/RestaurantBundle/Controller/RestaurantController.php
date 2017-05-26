<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateInterval;
use Symfony\Component\HttpFoundation\Response;
use AmazonSNS;
use Swift;
class RestaurantController extends Controller
{


    /**
     * @Route("/")
     */
    public function indexAction($date="",$service=0)
    {
        if(empty($date))
            $date=new \DateTime();
        else
            $date=new \DateTime($date);

        $selectedservice=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($service);
        if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDateServiceSuperAdmin($date,$service);
            $statesfilter=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findBy(array('hideInFilter'=>0),array("orderInFilter"=>"ASC"));
            $nbrpax=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->CountDateServiceSuperadmin($date,$service);
        }else{
            $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDateServiceAdmin($date,$service);
            $statesfilter=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findBy(array('hideInFilter'=>0,'hideAdmin'=>0),array("orderInFilter"=>"ASC"));
            $nbrpax=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->CountDateServiceAdmin($date,$service);
        }
        
        $nbrpax=$nbrpax['nbrpax'];
        $siteopening=array();
        if($siteopening=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("SITEOPENINGHOURS")){
            $siteopening=json_decode($siteopening->getValue());
        }
        $selecteddate=$date;

        $services=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findAll();
        $lastsynchro = $this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("LASTSYNCHRONISATION");
        if(!$lastsynchro){
            $lastsynchro=new Config();
            $lastsynchro->setName("LASTSYNCHRONISATION");
            $lastsynchro->setValue("");
            $em = $this->getDoctrine()->getManager();
            $em->persist($lastsynchro);
            $em->flush();
        }
        $lastsynchronisation="";
        if($lastsynchro){
            $lastsynchronisation=$lastsynchro->getValue();
        }
        return $this->render('RestaurantBundle:index:index.html.twig',compact('books','services','selectedservice','selecteddate','statesfilter','nbrpax','lastsynchronisation'));
    }

    /**
     * @Route("/")
     */
    public function redirectToLoginAction()
    {
        return $this->redirectToRoute("fos_user_security_login");
    }
    /**
     * @Route("/send" , name="send")
     */
    public function sendAction()
    {
        $service=0;
        $date=new \DateTime();

        $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDateServiceSuperAdmin($date,$service);
        foreach ($books as $book)
        {

                $email=$book->getCustomerId()->getEmail();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Votre resa')
                    ->setFrom('resa@comptoirdarna.com')
                    ->setTo($email)
                    ->setBody(
                        $this->renderView(
                            'RestaurantBundle:emails:envoyer.html.twig',
                            compact('book')
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);
        }
       return new JsonResponse(array("msg"=>"ok"));

    }

    /**
     * @Route("/ResaEnCour")
     */
    public function resaEnCourAction($date="",$service=0)
    {
        if(empty($date))
            $date=new \DateTime();
        else
            $date=new \DateTime($date);
        $selectedservice=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findOneById($service);
        $books =$this->getDoctrine()->getRepository("RestaurantBundle:Book")->findByStateId(9);
        $statesfilter=$this->getDoctrine()->getRepository("RestaurantBundle:State")->findBy(array('hideInFilter'=>0,'hideAdmin'=>0),array("orderInFilter"=>"ASC"));
        $nbrpax=count($books);
        $siteopening=array();
        if($siteopening=$this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("SITEOPENINGHOURS")){
            $siteopening=json_decode($siteopening->getValue());
        }
        $selecteddate=$date;

        $services=$this->getDoctrine()->getRepository("RestaurantBundle:Service")->findAll();
        $lastsynchro = $this->getDoctrine()->getRepository("RestaurantBundle:Config")->findOneByName("LASTSYNCHRONISATION");
        if(!$lastsynchro){
            $lastsynchro=new Config();
            $lastsynchro->setName("LASTSYNCHRONISATION");
            $lastsynchro->setValue("");
            $em = $this->getDoctrine()->getManager();
            $em->persist($lastsynchro);
            $em->flush();
        }
        $lastsynchronisation="";
        if($lastsynchro){
            $lastsynchronisation=$lastsynchro->getValue();
        }
        return $this->render('RestaurantBundle:index:ResaEnCour.html.twig',compact('books','services','selectedservice','selecteddate','statesfilter','nbrpax','lastsynchronisation'));
    }
    /**
     * @Route("/remercier" ,name="remercier_restaurant")
     */
    public function remercierAction()
    {
        $service=0;
        $date=new \DateTime();
        $date=$date->sub(new DateInterval('P1D'));
        $date->setTime(5,00,00);

        $books=$this->getDoctrine()->getRepository("RestaurantBundle:Book")->SearchByDateServiceSuperAdmin($date,$service);
        foreach ($books as $book)
        {
            $email=$book->getCustomerId()->getEmail();
            $message = \Swift_Message::newInstance()
                ->setSubject('Votre resa')
                ->setFrom('resa@comptoirdarna.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'RestaurantBundle:emails:remercier.html.twig',
                        compact('book')
                    ),
                    'text/html'
                );
                $this->get('mailer')->send($message);
        }
        return new JsonResponse(array("msg"=>"OK"));

    }

}
