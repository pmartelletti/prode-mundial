<?php

namespace ProdeMundial\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProdeMundial\CoreBundle\Entity\User;
use JMS\Serializer\Annotation\Exclude;

/**
 * Prediction
 */
class Prediction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var User
     * @Exclude
     */
    private $user;

    /** @var  Game */
    private $game;

    /**
     * @var string
     */
    private $result;


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
     * Set result
     *
     * @param string $result
     * @return Prediction
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param \ProdeMundial\CoreBundle\Entity\User $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \ProdeMundial\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \ProdeMundial\CoreBundle\Entity\Game $game
     *
     * @return $this
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * @return \ProdeMundial\CoreBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }
}
