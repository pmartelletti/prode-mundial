<?php

namespace ProdeMundial\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;
use ProdeMundial\CoreBundle\Entity\Prediction;
use ProdeMundial\CoreBundle\Form\PredictionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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