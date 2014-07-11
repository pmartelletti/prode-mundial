<?php

namespace ProdeMundial\CoreBundle\Entity;

/**
 * Team
 */
class Team
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $flag;

    /**
     * @var string
     */
    private $flagUrl;


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
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set flag
     *
     * @param string $flag
     * @return Team
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return string 
     */
    public function getFlag()
    {
        return $this->flag;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param string $flagUrl
     *
     * @return $this
     */
    public function setFlagUrl($flagUrl)
    {
        $this->flagUrl = $flagUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getFlagUrl()
    {
        return $this->flagUrl;
    }
}
