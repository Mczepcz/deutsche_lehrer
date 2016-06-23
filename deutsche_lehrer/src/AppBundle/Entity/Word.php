<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WordRepository")
 */
class Word
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
     * @ORM\Column(name="PL", type="string", length=255)
     */
    private $pL;

    /**
     * @var string
     *
     * @ORM\Column(name="DE", type="string", length=255)
     */
    private $dE;

    /**
     * @var string
     *
     * @ORM\Column(name="PartOfSpeech", type="integer")
     */
    private $partOfSpeech;

    /**
     * @var integer
     *
     * @ORM\Column(name="gender", type="integer")
     */
    private $gender;

    /**
     * @var integer
     *
     * @ORM\Column(name="grammNumber", type="integer")
     */
    private $grammNumber;
    
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deck", inversedBy="words")
     * @var User
     */
    private $deck;
    
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
     * Set pL
     *
     * @param string $pL
     * @return Word
     */
    public function setPL($pL)
    {
        $this->pL = $pL;

        return $this;
    }

    /**
     * Get pL
     *
     * @return string 
     */
    public function getPL()
    {
        return $this->pL;
    }

    /**
     * Set dE
     *
     * @param string $dE
     * @return Word
     */
    public function setDE($dE)
    {
        $this->dE = $dE;

        return $this;
    }

    /**
     * Get dE
     *
     * @return string 
     */
    public function getDE()
    {
        return $this->dE;
    }

    /**
     * Set partOfSpeech
     *
     * @param string $partOfSpeech
     * @return Word
     */
    public function setPartOfSpeech($partOfSpeech)
    {
        $this->partOfSpeech = $partOfSpeech;

        return $this;
    }

    /**
     * Get partOfSpeech
     *
     * @return string 
     */
    public function getPartOfSpeech()
    {
        return $this->partOfSpeech;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Word
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set grammNumber
     *
     * @param string $grammNumber
     * @return Word
     */
    public function setGrammNumber($grammNumber)
    {
        $this->grammNumber = $grammNumber;

        return $this;
    }

    /**
     * Get grammNumber
     *
     * @return string 
     */
    public function getGrammNumber()
    {
        return $this->grammNumber;
    }

    /**
     * Set deck
     *
     * @param \AppBundle\Entity\Deck $deck
     * @return Word
     */
    public function setDeck(\AppBundle\Entity\Deck $deck = null)
    {
        $this->deck = $deck;

        return $this;
    }

    /**
     * Get deck
     *
     * @return \AppBundle\Entity\Deck 
     */
    public function getDeck()
    {
        return $this->deck;
    }
}
