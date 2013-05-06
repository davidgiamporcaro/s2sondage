<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dgiamporcaro
 * Date: 29/04/13
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

// src/Sondage/SurveyBundle/Controller/SurveyController.php

namespace Sondage\SurveyBundle\Controller;

use Sondage\SurveyBundle\Entity\Survey;
use Sondage\SurveyBundle\Form\Type\SurveyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Survey controller.
 */
class SurveyController extends Controller
{
    /**
     * Show a survey entry
     */
    public function displayAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('SondageSurveyBundle:Survey')->find($id);
        if (!$survey) {
            throw $this->createNotFoundException('Unable to find this survey.');
        }

        return $this->render('SondageSurveyBundle:Survey:display.html.twig', array(
            'survey'      => $survey,
        ));
    }

    /**
     * Show all user's survey
     */
    public function listAction()
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $surveys = $em->getRepository('SondageSurveyBundle:Survey')->findBy(array('userId' => $user->getId()));
            if (!$surveys) {
                throw $this->createNotFoundException('Unable to find any survey.');
            }

            return $this->render('SondageSurveyBundle:Survey:list.html.twig', array(
                'surveys'      => $surveys,
            ));
        }
    }

    /**
     * Show all user's survey
     */
    public function editAction($id = null)
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $em = $this->getDoctrine()->getManager();
            if (isset($id) && $id != 0) {
                $survey = $em->getRepository('SondageSurveyBundle:Survey')->find($id);
                if (!$survey) {
                    throw $this->createNotFoundException('Unable to find this survey.');
                }

            } else {
                $survey = new Survey();
            }

            $form = $this->createForm(new SurveyType(), $survey);

            $request = $this->getRequest();

            if ('POST' == $request->getMethod()) {
                $form->bind($request);
                $data = $form->getData();

                if ($form->isValid()) {
                    $survey->setTitle($data->getTitle());
                    $em->persist($survey);
                    $em->flush();

                    $this->get('session')->setFlash('success', 'New survey was saved!');

                }
                else {
                    $this->get('session')->setFlash('error', 'The survey was not saved!');
                }
            }


            return $this->render('SondageSurveyBundle:Survey:edit.html.twig', array(
                'survey'      => $survey,
                'form'      => $form->createView(),
            ));
        }
    }
}