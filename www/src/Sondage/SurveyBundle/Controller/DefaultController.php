<?php

namespace Sondage\SurveyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SondageSurveyBundle:Default:index.html.twig', array('name' => $name));
    }
}
