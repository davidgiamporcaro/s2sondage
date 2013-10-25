<?php

namespace Sondage\SettingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function configureAction()
    {
        return $this->render('SondageSettingsBundle:Default:configure.html.twig');
    }
}
