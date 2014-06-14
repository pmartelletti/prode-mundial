<?php
namespace ProdeMundial\CoreBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends FOSRestController
{
    public function tendencyAction(Request $request)
    {
        $game = $this->findOr404($request);

        return $this->get('prodemundial.core.predictions_handler')->getTendency($game);
    }

    /**
     * @param Request $request
     * @param string $identifier
     *
     * @return Game
     *
     * @throws NotFoundHttpException
     */
    public function findOr404(Request $request, $identifier = 'id')
    {

        $entity = $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:Game')
            ->find($request->get($identifier));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game.');
        }

        return $entity;
    }
} 