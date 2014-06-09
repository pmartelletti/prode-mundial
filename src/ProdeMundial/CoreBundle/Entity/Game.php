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
}
