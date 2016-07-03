<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Deck;
use AppBundle\Entity\Repeater;
use AppBundle\Entity\Word;
use AppBundle\Entity\User;

class MainController extends Controller
{
    /**
     * @Route("/", name="landingPage")
     * @Template("AppBundle:Main:landingPage.html.twig")
     */
    public function showLandPageAction(){
        return array();
    }
    /**
     * @Route("/main", name="mainPage")
     * @Template("AppBundle:Main:mainPage.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function showMainPageAction(){
        $loggedUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT d from AppBundle:Deck d WHERE d.user = :user')->setParameter('user',$loggedUser);
        $decks = $query->getResult();
        $decksWithNumbers = [];
        foreach($decks as $deck){
            $numbers=$this->getRepeatsNum($deck->getName());
            $decksWithNumbers[]=[$deck, $numbers['new'],$numbers["toRepeat"]];
            
        }
        return array("name"=>$loggedUser->getUsername(), "decks"=>$decksWithNumbers, "decks1"=>$decks);
        
    }
    /**
     * @Route("/show/{deck}", name="learnDeck")
     * @Template("AppBundle:Main:deckPage.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function showDeckAction($deck){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deck);
        $numbers = $this->getRepeatsNum($deck);
        $newWordsNum = $numbers["new"];
        $toRepeatWordNum = $numbers["toRepeat"];
        

        return array("deck"=>$currentDeck, "newNum"=>$newWordsNum, "toRepeatNum"=>$toRepeatWordNum);
    }
    /**
     * @Route("/study/{deck}", name="study")
     * @Template("AppBundle:Main:studyPage.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function learnAction($deck){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deck);
        $loggedUser = $this->getUser();
        $newWords =  $this->getDoctrine()->getRepository('AppBundle:Repeater')->findNewWords($loggedUser, $currentDeck);
        $toRepeatWords = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findtoRepeatWords($loggedUser, $currentDeck);
        $wordsToLearn = $newWords + $toRepeatWords;
        $wordsNum = count($wordsToLearn);
        if($wordsNum == 0){
            return $this->redirect($this->generateUrl('learnDeck', array('deck' => $deck)));
        }
        return array("words"=> $wordsToLearn, "deck"=>$currentDeck, "wordsNum"=>$wordsNum);
    }
    /**
     * Return array of numbers of new words in repeater and words to repeat
     * 
     * @param string $deckName
     * @return array
     */
    public function getRepeatsNum($deckName){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deckName);
        $loggedUser = $this->getUser();
        $newWords =  $this->getDoctrine()->getRepository('AppBundle:Repeater')->findNewWords($loggedUser, $currentDeck);
        $toRepeatWords = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findtoRepeatWords($loggedUser, $currentDeck);
        $toRepeatWordNum = count($toRepeatWords);
        $newWordsNum = count($newWords);
        $numbers = ["new"=>$newWordsNum, "toRepeat"=>$toRepeatWordNum];
        return $numbers;
    }
    /**
     * @Route("/study/{deck}/{id}/{q}", name="repeat")
     * @Template("AppBundle:Main:testPage.html.twig")
     *  
     */
    public function calculateNewRepeatAction($id, $q, $deck){
        $em = $this->getDoctrine()->getManager();
        $currentRepeater = $em->getRepository('AppBundle:Repeater')->find($id);
        if($q >= 3) {
            $currentRepeater->setRepeatCode($currentRepeater->getRepeatCode()+1);
        } else {
            $currentRepeater->setRepeatCode(1);
        }
        
        $newEfactor =  $currentRepeater->getEfactor()-0.8+0.28*$q-0.02*$q*$q;
        $currentRepeater->setEfactor($newEfactor);
        
        function calaculateInterval($RepeatCode, $Efactor){
            if($RepeatCode == 1){
                $interval=1;
            } elseif($RepeatCode == 2) {
                $interval = 6;
            } else {
                $interval = calaculateInterval($RepeatCode - 1, $Efactor) * $Efactor;
            }
            
            return ceil($interval);    
        }
        $interval = calaculateInterval($currentRepeater->getRepeatCode(),$newEfactor);
        $interval = new \DateInterval("P".$interval."D");
        $date = new \DateTime();
        $date->add($interval);
        if($q >= 3){
           $currentRepeater->setRepeatDate($date);
        } else {
            $currentRepeater->setRepeatDate(new \DateTime());
        }
        
        $newDate=$currentRepeater->getRepeatDate(); 
        $em->flush();
        
        return $this->redirect($this->generateUrl('study', array('deck' => $deck)));
     
    }
}
