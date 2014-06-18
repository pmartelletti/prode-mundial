<?php
namespace ProdeMundial\CoreBundle\Handler;


use Doctrine\ORM\EntityManager;
use ProdeMundial\CoreBundle\Entity\Game;
use ProdeMundial\CoreBundle\Entity\Team;
use ProdeMundial\CoreBundle\Entity\TeamsGroup;

class TeamGroupHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getTeamStandings(TeamsGroup $group)
    {
        $positions = array();
        foreach($group->getGames() as $k => $game) {
            $away = $game->getAwayTeam();
            $home = $game->getHomeTeam();
            if (!array_key_exists($away->getName(), $positions)) {
                $positions[$away->getName()] = $this->generateTableFields($away, $positions);
            }
            if (!array_key_exists($home->getName(), $positions)) {
                $positions[$home->getName()] = $this->generateTableFields($home, $positions);
            }
            if ($game->isPlayed()) {
                $positions = $this->addGameResult($game, $positions, "H");
                $positions = $this->addGameResult($game, $positions, "A");

            }
        }
        // order the array
        usort($positions, array($this, 'standingsCmp'));

        return $positions;
    }

    public function standingsCmp(array $a, array $b)
    {
        // dif punts
        if (($cmp = strcmp($a['PTS'], $b['PTS'])) !== 0) {
            return -$cmp;
        } else if (($cmp = $a['DG'] - $b['DG']) !== 0) {
            return -$cmp;
        } else if (($cmp = strcmp($a['GF'], $b['GF'])) !== 0) {
            return -$cmp;
        } else  {
            return -strcmp($a['GC'], $b['GC']);
        }
    }

    public function generateTableFields(Team $team, array $positions)
    {
        return array(
            'name' => $team->getName(),
            'PTS' => 0,
            'PJ' => 0,
            'PG' => 0,
            'PE' => 0,
            'PP' => 0,
            'GF' => 0,
            'GC' => 0,
            'DG' => 0
        );
    }

    private function addGameResult(Game $game, $positions, $condition)
    {
        $conditionTeam = sprintf('get%sTeam', $condition == "H" ? "Home" : "Away");
        $conditionTeam = call_user_func(array($game, $conditionTeam))->getName();
        $conditionGoals = sprintf('get%sGoals', $condition == "H" ? "Home" : "Away");
        $otherGoals = sprintf('get%sGoals', $condition == "H" ? "Away" : "Home");
        if ($condition == $game->getProdeResult()) {
            $positions[$conditionTeam]['PTS'] += 3;
            $positions[$conditionTeam]['PG'] += 1;
        }
        else if ($game->getProdeResult() == "D") {
            $positions[$conditionTeam]['PTS'] += 1;
            $positions[$conditionTeam]['PE'] += 1;
        } else {
            $positions[$conditionTeam]['PP'] += 1;
        }

        // we add other stats
        $positions[$conditionTeam]['PJ'] += 1;
        $positions[$conditionTeam]['GF'] += call_user_func(array($game, $conditionGoals));
        $positions[$conditionTeam]['GC'] += call_user_func(array($game, $otherGoals));
        $positions[$conditionTeam]['DG'] +=
            call_user_func(array($game, $conditionGoals)) - call_user_func(array($game, $otherGoals));

        return $positions;
    }
} 