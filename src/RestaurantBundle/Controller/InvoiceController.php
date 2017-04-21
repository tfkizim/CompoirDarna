<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class InvoiceController extends Controller
{
    /**
     * @Route("/invoice")
     */
    public function indexAction()
    {
        return $this->render('RestaurantBundle:invoice:index.html.twig');
    }
}
