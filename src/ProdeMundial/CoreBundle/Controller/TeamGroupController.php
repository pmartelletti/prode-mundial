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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TeamGroupController extends FOSRestController
{
    /**
     * @View("ProdeMundialWebBundle:Frontend/Standings:groups.html.twig", statusCode=200)
     */
    public function standingsAction(Request $request)
    {
        $group = $this->findOr404($request);

        return array(
            'group' => $group,
            'groups' => $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:TeamsGroup')->findAll(),
            'standings' => $this->get('prodemundial.core.groups_handler')->getTeamStandings($group),
            'slug' => $request->get('slug')
        );
    }

    /**
     * @param Request $request
     * @param string $identifier
     *
     * @return TeamsGroup
     *
     * @throws NotFoundHttpException
     */
    public function findOr404(Request $request, $identifier = 'slug')
    {

        $entity = $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:TeamsGroup')
            ->findOneBySlug($request->get($identifier));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group.');
        }

        return $entity;
    }
} 