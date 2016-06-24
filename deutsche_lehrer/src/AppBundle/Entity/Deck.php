<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Deck
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DeckRepository")
 */
class Deck
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="decks")
     * @var User
     */
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Word", mappedBy="deck")
     * @var ArrayCollection
     */
    private $words;
    
    public function __construct(){
        $this->words = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Deck
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Deck
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
     * Add words
     *
     * @param \AppBundle\Entity\Word $words
     * @return Deck
     */
    public function addWord(\AppBundle\Entity\Word $words)
    {
        $this->words[] = $words;

        return $this;
    }

    /**
     * Remove words
     *
     * @param \AppBundle\Entity\Word $words
     */
    public function removeWord(\AppBundle\Entity\Word $words)
    {
        $this->words->removeElement($words);
    }

    /**
     * Get words
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWords()
    {
        return $this->words;
    }
    public function __toString(){
        return $this->name;
    }
}
