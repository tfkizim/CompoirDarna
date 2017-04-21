<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TaskController extends Controller
{
    /**
     * @Route("/task")
     */
    public function indexAction()
    {
        return $this->render('RestaurantBundle:task:index.html.twig');
    }
}
