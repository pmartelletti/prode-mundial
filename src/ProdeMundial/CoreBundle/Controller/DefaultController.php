<?php

namespace ProdeMundial\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProdeMundialWebBundle:Default:index.html.twig', array(
            'nextGames' => $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:Game')->findNextGames(),
            'recentGames' => $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:Game')->findRecentGames(),
        ));
    }
}
