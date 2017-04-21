<?php

namespace RestaurantBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DatabaseGlobalsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

   protected $em;
   protected $tokenStorage;

   public function __construct(EntityManager $em,TokenStorage $tokenStorage)
   {
      $this->em = $em;
      $this->tokenStorage = $tokenStorage;
   }

   public function getGlobals()
   {
      $request = Request::createFromGlobals();
      if(empty($request->query->get('date')))
         $date=new \DateTime();
      else
         $date=new \DateTime($request->query->get('date'));
      $datenow=new\DateTime();
      //Booooks here

      $books=$this->em->getRepository("RestaurantBundle:Book")->SearchByDate($date);
      $floors=$this->em->getRepository("RestaurantBundle:Floor")->findAll();
      $states=$this->em->getRepository("RestaurantBundle:State")->findBy(array(),array("orderInFilter"=>"ASC"));
      $offers=$this->em->getRepository("RestaurantBundle:Offer")->findBy(array(),array("orderInFilter"=>"ASC"));
      $occasions=$this->em->getRepository("RestaurantBundle:Occasion")->findBy(array(),array("orderInFilter"=>"ASC"));
      $services=$this->em->getRepository("RestaurantBundle:Service")->findAll();
      $notifications=array();
      $notifications=$this->em->getRepository("RestaurantBundle:Notification")->AllLimited();
      $booktables=array();
      foreach($books as $b){
         foreach($b->getBooktabls() as $bt){
            $booktables[$bt->getTablId()->getId()][$b->getDateBook()->format("U")]=$b;
         }
      }
      $configurations=$this->em->getRepository('RestaurantBundle:Config')->findAll();
      $globalconfig=array();
      foreach($configurations as $config){
         $globalconfig[$config->getName()]=$config->getValue();
      }
      $user=null;
      $token=$this->tokenStorage->getToken();
      if($token){
         $user=$token->getUser();
      }
      return array (
              'globalconfig' => $globalconfig,'connecteduser'=>$user,'datenow'=>$datenow,/*'booktables'=>$booktables,*/
              'floors'=>$floors,'states'=>$states,'offers'=>$offers,'occasions'=>$occasions,'services'=>$services,'notifications'=>$notifications,
      );
   }

   public function getName()
   {
      return 'RestaurantBundle:DatabaseGlobalsExtension';
   }

}