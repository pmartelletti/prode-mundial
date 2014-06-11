<?php

namespace ProdeMundial\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 */
class Game
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $venue;

    /**
     * @var Team
     */
    private $homeTeam;

    /**
     * @var Team
     */
    private $awayTeam;

    /**
     * @var integer
     */
    private $awayGoals;

    /**
     * @var string
     */
    private $homeGoals;

    /**
     * @var string
     */
    private $prodeResult;

    /**
     * @var TeamsGroup
     */
    private $group;

    /**
     * @var integer
     */
    private $fifaMatchId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Game
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $venue
     *
     * @return $this
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
        return $this;
    }

    /**
     * @return string
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * Set awayGoals
     *
     * @param integer $awayGoals
     * @return Game
     */
    public function setAwayGoals($awayGoals)
    {
        $this->awayGoals = $awayGoals;

        return $this;
    }

    /**
     * Get awayGoals
     *
     * @return integer 
     */
    public function getAwayGoals()
    {
        return $this->awayGoals;
    }

    /**
     * Set homeGoals
     *
     * @param string $homeGoals
     * @return Game
     */
    public function setHomeGoals($homeGoals)
    {
        $this->homeGoals = $homeGoals;

        return $this;
    }

    /**
     * Get homeGoals
     *
     * @return string 
     */
    public function getHomeGoals()
    {
        return $this->homeGoals;
    }

    /**
     * Set prodeResult
     *
     * @param string $prodeResult
     * @return Game
     */
    public function setProdeResult($prodeResult)
    {
        $this->prodeResult = $prodeResult;

        return $this;
    }

    /**
     * Get prodeResult
     *
     * @return string 
     */
    public function getProdeResult()
    {
        return $this->prodeResult;
    }

    /**
     * @param \ProdeMundial\CoreBundle\Entity\TeamsGroup $group
     *
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return \ProdeMundial\CoreBundle\Entity\TeamsGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param \ProdeMundial\CoreBundle\Entity\Team $homeTeam
     *
     * @return $this
     */
    public function setHomeTeam($homeTeam)
    {
        $this->homeTeam = $homeTeam;
        return $this;
    }

    /**
     * @return \ProdeMundial\CoreBundle\Entity\Team
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * @param \ProdeMundial\CoreBundle\Entity\Team $awayTeam
     *
     * @return $this
     */
    public function setAwayTeam($awayTeam)
    {
        $this->awayTeam = $awayTeam;
        return $this;
    }

    /**
     * @return \ProdeMundial\CoreBundle\Entity\Team
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * @param int $fifaMatchId
     *
     * @return $this
     */
    public function setFifaMatchId($fifaMatchId)
    {
        $this->fifaMatchId = $fifaMatchId;
        return $this;
    }

    /**
     * @return int
     */
    public function getFifaMatchId()
    {
        return $this->fifaMatchId;
    }

    public function isPlayed()
    {
        $now = new \DateTime();

        return ($this->getDate() < $now) and ($this->getProdeResult());
    }
}
