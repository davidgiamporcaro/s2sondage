<?php

namespace Sondage\SurveyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('SondageSurveyBundle:Page:index.html.twig');
    }
}
