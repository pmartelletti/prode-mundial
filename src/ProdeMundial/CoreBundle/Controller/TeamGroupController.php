<?php
namespace ProdeMundial\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
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