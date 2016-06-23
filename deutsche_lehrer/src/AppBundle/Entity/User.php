<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Deck", mappedBy="user")
     * @var ArrayCollection
     */
    protected $decks;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Repeater", mappedBy="user")
     * @var ArrayCollection
     */
    protected $repeaters;

    public function __construct()
    {
        parent::__construct();
        $this->decks = new ArrayCollection();
        $this->repeaters = new ArrayCollection();
 
    }

    /**
     * Add decks
     *
     * @param \AppBundle\Entity\Deck $decks
     * @return User
     */
    public function addDeck(\AppBundle\Entity\Deck $decks)
    {
        $this->decks[] = $decks;

        return $this;
    }

    /**
     * Remove decks
     *
     * @param \AppBundle\Entity\Deck $decks
     */
    public function removeDeck(\AppBundle\Entity\Deck $decks)
    {
        $this->decks->removeElement($decks);
    }

    /**
     * Get decks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDecks()
    {
        return $this->decks;
    }

    /**
     * Add repeaters
     *
     * @param \AppBundle\Entity\Repeater $repeaters
     * @return User
     */
    public function addRepeater(\AppBundle\Entity\Repeater $repeaters)
    {
        $this->repeaters[] = $repeaters;

        return $this;
    }

    /**
     * Remove repeaters
     *
     * @param \AppBundle\Entity\Repeater $repeaters
     */
    public function removeRepeater(\AppBundle\Entity\Repeater $repeaters)
    {
        $this->repeaters->removeElement($repeaters);
    }

    /**
     * Get repeaters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRepeaters()
    {
        return $this->repeaters;
    }
}
