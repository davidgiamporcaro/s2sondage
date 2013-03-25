<?php

namespace Sondage\AuthenticatedUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SondageAuthenticatedUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
