<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
        return array("name"=>$loggedUser->getUsername(), "decks"=>$decks);
        
    }
    /**
     * @Route("/learn/{deck}", name="learnDeck")
     * @Template("AppBundle:Main:deckPage.html.twig")
     */
    public function showDeckAction($deck){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deck);
        //$currentRepeater = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findByUser($loggedUser);
        $loggedUser = $this->getUser();
        $newWords =  $this->getDoctrine()->getRepository('AppBundle:Repeater')->findNewWords($loggedUser, $currentDeck);
        $toRepeatWords = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findtoRepeatWords($loggedUser, $currentDeck);
        $toRepeatWordNum = count($toRepeatWords);
        $newWordsNum = count($newWords);
        return array("deck"=>$currentDeck, "newNum"=>$newWordsNum, "toRepeatNum"=>$toRepeatWordNum);
    }
    /**
     * @Route("/study/{deck}/{n}", name="study", defaults={"n" = 0})
     * @Template("AppBundle:Main:studyPage.html.twig")
     * @param type $deck
     */
    public function learnAction($deck, $n){
        $currentDeck = $this->getDoctrine()->getRepository('AppBundle:Deck')->findOneByName($deck);
        $loggedUser = $this->getUser();
        
        $currentRepeater = $this->getDoctrine()->getRepository('AppBundle:Repeater')->findByUser($loggedUser);
        $wordsNum = count(currentRepeater);
        
        return array("words"=>$words, "deck"=>$currentDeck, "n"=>$n, "wordsNum"=>$wordsNum);
    }
}
