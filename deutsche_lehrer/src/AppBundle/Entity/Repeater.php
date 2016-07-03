<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repeater
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RepeaterRepository")
 */
class Repeater
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="repeatDate", type="datetime")
     */
    private $repeatDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="repeatCode", type="integer")
     */
    private $repeatCode;
    
    /**
     * @var float
     * @ORM\Column(name="Efactor", type="float")
     */
    private $Efactor;
    
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="repeaters")
     * @var User
     */
    private $user;
    
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Word")
     * @var Word
     */
    private $word;

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
     * Set repeatDate
     *
     * @param \DateTime $repeatDate
     * @return Repeater
     */
    public function setRepeatDate($repeatDate)
    {
        $this->repeatDate = $repeatDate;

        return $this;
    }

    /**
     * Get repeatDate
     *
     * @return \DateTime 
     */
    public function getRepeatDate()
    {
        return $this->repeatDate;
    }

    /**
     * Set repeatCode
     *
     * @param integer $repeatCode
     * @return Repeater
     */
    public function setRepeatCode($repeatCode)
    {
        $this->repeatCode = $repeatCode;

        return $this;
    }

    /**
     * Get repeatCode
     *
     * @return integer 
     */
    public function getRepeatCode()
    {
        return $this->repeatCode;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Repeater
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set word
     *
     * @param \AppBundle\Entity\Word $word
     * @return Repeater
     */
    public function setWord(\AppBundle\Entity\Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \AppBundle\Entity\Word 
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set Efactor
     *
     * @param \double $efactor
     * @return Repeater
     */
    public function setEfactor($efactor)
    {
        $this->Efactor = $efactor;

        return $this;
    }

    /**
     * Get Efactor
     *
     * @return \double 
     */
    public function getEfactor()
    {
        return $this->Efactor;
    }
}
