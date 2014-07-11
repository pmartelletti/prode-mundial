<?php

namespace ProdeMundial\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;

class StandingsController extends FOSRestController
{
    /**
     * @View("ProdeMundialWebBundle:Frontend/Standings:index.html.twig", statusCode=200)
     */
    public function indexAction()
    {
        return array(
            'generalStandings' => $this->get('prodemundial.core.standings_handler')->getGeneralStandings(),
            'paidStandings' => $this->get('prodemundial.core.standings_handler')->getPaidStandings(),
            'freeStandings' => $this->get('prodemundial.core.standings_handler')->getFreeStandings(),
        );
    }
} 