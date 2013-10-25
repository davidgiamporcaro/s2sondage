<?php

namespace Sondage\SettingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sondage\SettingsBundle\Form\Type\SettingsType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function configureAction()
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->getRepository('SondageSettingsBundle:Settings')->createQueryBuilder('s');
            $settings = $qb->select('s');
            if (!$settings) {
                throw $this->createNotFoundException('Unable to find any settings.');
            }
            $form = $this->createForm(new SettingsType());
            return $this->render('SondageSettingsBundle:Default:configure.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}
