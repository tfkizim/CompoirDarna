<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CalendarController extends Controller
{

    /**
     * @Route("/calendar")
     */
    public function indexAction()
    {
        return $this->render('RestaurantBundle:calendar:index.html.twig');
    }
}
