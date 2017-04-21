<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NoteController extends Controller
{
    /**
     * @Route("/note")
     */
    public function indexAction()
    {
        return $this->render('RestaurantBundle:note:index.html.twig');
    }
}
