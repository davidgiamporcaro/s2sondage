<?php

namespace Sondage\SettingsBundle\Controller;

use Sondage\SettingsBundle\SondageSettingsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sondage\SettingsBundle\Form\Type\SettingsType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sondage\SettingsBundle\Entity\Settings;
use Sondage\SettingsBundle\Entity\Document;


class DefaultController extends Controller
{
    public function configureAction()
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $em = $this->getDoctrine()->getManager();
            $settings = new Settings();
            $form = $this->createForm(new SettingsType, $settings);

            $request = $this->getRequest();
            if ('POST' == $request->getMethod()) {
                $form->bind($request);
                if ($form->isValid()) {
                    $document = $settings->getDocuments();
                    $em->persist($settings);
                    $em->persist($document);
                    $em->flush();

                    $this->get('session')->setFlash('success', 'New settings was saved!');

                }
                else {
                    $this->get('session')->setFlash('error', 'The settings was not saved!');
                }
            }

            return $this->render('SondageSettingsBundle:Default:configure.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        else {
            throw new AccessDeniedException();
        }
    }
}
