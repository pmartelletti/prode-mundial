<?php

namespace ProdeMundial\CoreBundle\Manager;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use ProdeMundial\CoreBundle\Entity\Prediction;
use ProdeMundial\CoreBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class PredictionsCreator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createPredictions(FilterUserResponseEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $this->createPredictionsForUser($user);
    }

    public function createPredictionsForUser(UserInterface $user)
    {
        $games = $this->em->getRepository('ProdeMundialCoreBundle:Game')->findAll();
        // we create a prediction for all the games
        foreach($games as $game) {
            $prediction = new Prediction();
            $prediction->setGame($game);

            $user->addPrediction($prediction);
        }

        $this->em->flush();
    }
} 