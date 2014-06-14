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

class PredictionsController extends FOSRestController
{
    /**
     * @View("ProdeMundialWebBundle:Frontend/Predictions:index.html.twig", statusCode=200)
     */
    public function myPredictionsAction()
    {
        return array(
            'groups' => $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:TeamsGroup')->findAll()
        );
    }

    /**
     * @View(templateVar="predictions")
     */
    public function indexAction()
    {
        return $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:Prediction')->findByUser($this->getUser());
    }

    public function updateAction(Request $request)
    {
        $prediction = $this->findOr404($request);
        $lastUpdatableTime = $prediction->getGame()->getDate()->sub(new \DateInterval('PT20M'));

        if ($lastUpdatableTime < new \DateTime() )
        {
            return new JsonResponse(array(
                "message" => "La Veda Para este partido ya ha empezado",
                "status" => "error"
            ));
        }

        $form = $this->createForm(new PredictionType(), $prediction, array(
            'method' => 'PATCH'
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            // events?
            $this->getDoctrine()->getManager()->flush();
            // events?

            return $this->routeRedirectView('predictions_list', array(), Codes::HTTP_NO_CONTENT);
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param string $identifier
     *
     * @return Prediction
     *
     * @throws NotFoundHttpException
     */
    public function findOr404(Request $request, $identifier = 'id')
    {

        $entity = $this->getDoctrine()->getRepository('ProdeMundialCoreBundle:Prediction')
            ->find($request->get($identifier));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prediction.');
        }

        return $entity;
    }
}