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
    public function SlideshowParametersAction()
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->getRepository('SondageSettingsBundle:Settings')->createQueryBuilder('s');
            $slideShow_parameters = $qb->select('s')
                ->setParameter('title', 'slideshow_parameters');
            if (!$slideShow_parameters) {
                throw $this->createNotFoundException('Unable to find any slideshow parameters.');
            }

            // New settings parameters
            $settings = new Settings();
            $settings->setTitle('slideshow_parameters');
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
                'slideshow_parameters' => array()//$slideShow_parameters,
            ));
        }
        else {
            throw new AccessDeniedException();
        }
    }
}
