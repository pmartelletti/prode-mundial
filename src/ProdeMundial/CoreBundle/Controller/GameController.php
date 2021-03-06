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