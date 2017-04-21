<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ChatController extends Controller
{
    /**
     * @Route("/chat")
     */
    public function indexAction()
    {
        return $this->render('RestaurantBundle:chat:index.html.twig');
    }
}
