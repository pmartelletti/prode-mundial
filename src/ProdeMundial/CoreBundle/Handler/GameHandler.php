<?php
namespace ProdeMundial\CoreBundle\Handler;


use Doctrine\ORM\EntityManager;

class GameHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNextGamesGroupedByDate($games = 5)
    {
        $games = $this->em->getRepository('ProdeMundialCoreBundle:Game')->findNextGames($games);

        $result = [];
        $date = null;
        foreach($games as $game) {
            if (empty($date) or $date->format('d/m') != $game->getDate()->format('d/m')) {
                $date = $game->getDate();
                $result[$date->format('d/m')] = array(
                    'games' => array(),
                    'date' => $date
                );
            }
            $result[$date->format('d/m')]['games'][] = $game;
        }

        return $result;
    }
} 