<?php

namespace ProdeMundial\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ProdeMundialWebBundle:Default:index.html.twig', array('name' => $name));
    }
}
