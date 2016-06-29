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
            $numbers=$this->getRepeatsNum($deck);
            $decksWithNumbers[]=[$deck, $numbers['new'],$numbers["toRepeat"]];
            
        }
        return array("name"=>$loggedUser->getUsername(), "decks"=>$decksWithNumbers);
        
    }
    /**
     * @Route("/learn/{deck}", name="learnDeck")
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
     * @Route("/study/{deck}/{n}", name="study", defaults={"n" = 0})
     * @Template("AppBundle:Main:studyPage.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function learnAction($deck, $n){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deck);
        $loggedUser = $this->getUser();
        
        $currentRepeater = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findByUser($loggedUser);
        $wordsNum = count($currentRepeater);
        
        return array("words"=>$words, "deck"=>$currentDeck, "n"=>$n, "wordsNum"=>$wordsNum);
    }
    
    public function getRepeatsNum($deck){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deck);
        $loggedUser = $this->getUser();
        $newWords =  $this->getDoctrine()->getRepository('AppBundle:Repeater')->findNewWords($loggedUser, $currentDeck);
        $toRepeatWords = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findtoRepeatWords($loggedUser, $currentDeck);
        $toRepeatWordNum = count($toRepeatWords);
        $newWordsNum = count($newWords);
        $numbers = ["new"=>$newWordsNum, "toRepeat"=>$toRepeatWordNum];
        return $numbers;
    }
}
