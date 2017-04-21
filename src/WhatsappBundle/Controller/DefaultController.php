<?php

namespace WhatsappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use WhatsappBundle\Models\WhatsProt;
use WhatsappBundle\Models\Registration;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
    	/*$bin=new BinTreeNodeReader();
    	print_r($bin);exit;*/
        return $this->render('WhatsappBundle:Default:index.html.twig');
    }
    public function sendHelloAction(){
        set_time_limit(10);
        date_default_timezone_set('Europe/Madrid');
        $username='212629293812';
        $password = 'JOtNlFcivVgaHyO5mnV2SF5VM0g=';     // Use registerTool.php or exampleRegister.php to obtain your password
        $nickname = 'test';                          // This is the username (or nickname) displayed by WhatsApp clients.
        $target = "212630665912";                   // Destination telephone number including the country code without '+' or '00'.
        $debug = true;
        $w= new WhatsProt($username,$nickname,$debug);
        $w->connect();
        $w->loginWithPassword($password);
        $w->sendGetProfilePicture($target,true);
        $w->sendMessageLocation($target,'31.6559927','-8.0194189');
        $w->sendMessage($target,'Hello World! i am Yassine.');
        while($w->pollMessage());
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"ok"));
    }
    public function registrationAction($username){
        $debug=true;
        $username = str_replace('+', '', trim($username));
        if (!preg_match('!^\d+$!', $username)) {
            echo "Wrong number. Do NOT use '+' or '00' before your number\n";
            exit(0);
        }
        $identityExists = file_exists("../Models/wadata/id.$username.dat");
        $w = new Registration($username, $debug);

        if (!$identityExists) {
            $option = "sms";

            try {
                $w->codeRequest(trim($option));
            } catch (Exception $e) {
                echo $e->getMessage()."\n";
                exit(0);
            }

        } else {
            try {
                $result = $w->checkCredentials();
            } catch (Exception $e) {
                echo $e->getMessage()."\n";
                exit(0);
            }
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"ok"));
    }
    public function codeAction($username,$code){
        $debug=true;
        $username = str_replace('+', '', trim($username));
        if (!preg_match('!^\d+$!', $username)) {
            echo "Wrong number. Do NOT use '+' or '00' before your number\n";
            exit(0);
        }
        $w = new Registration($username, $debug);
        try {
            $result = $w->codeRegister(trim($code));
            echo "\nYour username is: ".$result->login."\n";
            echo 'Your password is: '.$result->pw."\n";
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
            exit(0);
        }
        $response = new JsonResponse();
        return $response->setData(array('reponse'=>"ok"));
    }
}
