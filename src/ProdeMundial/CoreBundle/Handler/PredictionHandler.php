<?php
namespace ProdeMundial\CoreBundle\Handler;


use Doctrine\ORM\EntityManager;
use ProdeMundial\CoreBundle\Entity\Game;

class PredictionHandler
{
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('ProdeMundialCoreBundle:Prediction');
    }

    public function getTendency(Game $game)
    {
        return array(
            "game" => $game->__toString(),
            "data" => array(
                array("label" => $game->getHomeTeam()->getName(), "data" => $this->getBaseTendencyQuery($game, "H")),
                array("label" => "Empate", "data" => $this->getBaseTendencyQuery($game, "D")),
                array("label" => $game->getAwayTeam()->getName(), "data" => $this->getBaseTendencyQuery($game, "A"))
            )
        );
    }

    /**
     * @param Game $game
     * @param string $prediction
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getBaseTendencyQuery(Game $game, $prediction)
    {
        $query = $this->repository->createQueryBuilder('p')
            ->select('count(p.id) as total')
            ->andWhere('p.game = :game')
            ->andWhere('p.result = :prediction')
            ->setParameter('game', $game)
            ->setParameter('prediction', $prediction)
        ;

        return $query->getQuery()->getSingleScalarResult();
    }
} 