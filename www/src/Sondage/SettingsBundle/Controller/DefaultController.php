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
            $slideshow_pictures = $qb->select('s')
                ->where('s.title = :title')
                ->setParameter('title', 'slideshow_pictures')
                ->getQuery();
;
            if (!$slideshow_pictures) {
                throw $this->createNotFoundException('Unable to find any slideshow pictures.');
            }

            // New settings parameters
            $settings = new Settings();
            $settings->setTitle('slideshow_pictures');
            $form = $this->createForm(new SettingsType, $settings);

            $request = $this->getRequest();
            if ('POST' == $request->getMethod()) {
                $form->bind($request);
                if ($form->isValid()) {
                    $document = $settings->getDocuments();
                    $em->persist($settings);
                    $em->persist($document);
                    $em->flush();

                    $this->get('session')->getFlashBag()->set('success', 'New settings was saved!');

                }
                else {
                    $this->get('session')->getFlashBag()->set('error', 'The settings was not saved!');
                }
            }
            return $this->render('SondageSettingsBundle:Default:configure.html.twig', array(
                'form' => $form->createView(),
                'slideshow_pictures' => $slideshow_pictures->getResult(),
            ));
        }
        else {
            throw new AccessDeniedException();
        }
    }

    public function removepictureAction()
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $em = $this->getDoctrine()->getManager();

            $id = $_POST['id'];
            $settings = $em->getRepository('SondageSettingsBundle:Settings')->find($id);
            $em->remove($settings);
            $em->flush();

            //$em = $this->getDoctrine()->getManager();
            $qb = $em->getRepository('SondageSettingsBundle:Settings')->createQueryBuilder('s');
            $slideshow_pictures = $qb->select('s')
                ->where('s.title = :title')
                ->setParameter('title', 'slideshow_pictures')
                ->getQuery();

            if (!$slideshow_pictures) {
                throw $this->createNotFoundException('Unable to find any slideshow pictures.');
            }

            return $this->render('SondageSettingsBundle:Default:slideshowPictures.html.twig', array(
                'slideshow_pictures' => $slideshow_pictures->getResult(),
            ));
        }
        else {
            throw new AccessDeniedException();
        }
    }
}
