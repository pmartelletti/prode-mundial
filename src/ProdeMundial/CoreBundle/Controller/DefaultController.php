<?php

namespace ProdeMundial\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProdeMundialWebBundle:Default:index.html.twig', array(
            'nextGames' => $this->get('prodemundial.core.game_handler')->getNextGamesGroupedByDate(8),
            'recentGames' => $this->get('prodemundial.core.game_handler')->getLastGamesGroupedByDate(8)
        ));
    }
}
