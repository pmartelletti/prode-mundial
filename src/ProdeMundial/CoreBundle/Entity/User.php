<?php

namespace ProdeMundial\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var boolean
     */
    private $paymentDone = false;

    /**
     * @var Prediction[]
     */
    private $predictions;

    /**
     * @var \DateTime
     */
    private $paymentDate;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    public function __construct()
    {
        parent::__construct();
        $this->predictions = new ArrayCollection();
    }

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
     * Set paymentDone
     *
     * @param boolean $paymentDone
     * @return User
     */
    public function setPaymentDone($paymentDone)
    {
        $this->paymentDone = $paymentDone;

        return $this;
    }

    /**
     * Get paymentDone
     *
     * @return boolean 
     */
    public function getPaymentDone()
    {
        return $this->paymentDone;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     * @return User
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime 
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function addPrediction(Prediction $prediction)
    {
        $prediction->setUser($this);
        if (!$this->predictions->contains($prediction)) {
            $this->predictions->add($prediction);
        }

        return $this;
    }

    public function removePrediction(Prediction $prediction)
    {
        $prediction->setUser(null);
        if ($this->predictions->contains($prediction)) {
            $this->predictions->removeElement($prediction);
        }

        return $this;
    }

    /**
     * @param \ProdeMundial\CoreBundle\Entity\Prediction[] $predictions
     *
     * @return $this
     */
    public function setPredictions($predictions)
    {
        $this->predictions = $predictions;
        return $this;
    }

    /**
     * @return \ProdeMundial\CoreBundle\Entity\Prediction[]
     */
    public function getPredictions()
    {
        return $this->predictions;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
}
