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
        return array("name"=>$loggedUser->getUsername());
        
    }
}
