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
            $qb = $em->getRepository('SondageSurveyBundle:Survey')->createQueryBuilder('s');
            $surveys = $qb->select('s')
                ->where('s.userId = :userId')
                ->setParameter('userId', $user->getId());
            if (!$surveys) {
                throw $this->createNotFoundException('Unable to find any survey.');
            }

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate($surveys,$this->get('request')->query->get('page', 1)/*page number*/,5/*limit per page*/);

            return $this->render('SondageSurveyBundle:Survey:list.html.twig', array(
                'pagination'   => $pagination,
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
                $user = $this->container->get('security.context')->getToken()->getUser();
                $survey->setAuthor($user->getUsername());
                $survey->setUserId($user->getId());
            }

            $form = $this->createForm(new SurveyType(), $survey);
            $form->add('description', 'ckeditor', array(
                'transformers'                 => array('strip_js', 'strip_css', 'strip_comments'),
                'toolbar'                      => array('document', 'clipboard', 'editing', 'basicstyles', 'paragraph', 'links', 'insert', 'styles', 'tools'),
                /*'toolbar_groups'               => array(
                    'document' => array('Source'),
                    'basicstyles' => array('Bold','Italic','Underline'),
                ),*/
                'startup_outline_blocks'       => false,
                'width'                        => '100%',
                'height'                       => '320',
                'language'                     => 'en-au',
                /*'filebrowser_image_browse_url' => array(
                    'url' => 'relative-url.php?type=file',
                ),
                'filebrowser_image_browse_url' => array(
                    'route'            => 'route_name',
                    'route_parameters' => array(
                        'type' => 'image',
                    ),
                ),*/
            ));
            $request = $this->getRequest();

            if ('POST' == $request->getMethod()) {
                $form->bind($request);

                if ($form->isValid()) {
                    $em->persist($survey);
                    $em->flush();

                    $this->get('session')->setFlash('success', 'The survey was saved!');

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
        else {
            throw new AccessDeniedException();
        }
    }

    public function removeAction()
    {
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();

            $id = $_POST['id'];
            $survey = $em->getRepository('SondageSurveyBundle:Survey')->find($id);
            $em->remove($survey);
            $em->flush();

            $qb = $em->getRepository('SondageSurveyBundle:Survey')->createQueryBuilder('s');
            $surveys = $qb->select('s')
                ->where('s.userId = :userId')
                ->setParameter('userId', $user->getId());
            if (!$surveys) {
                throw $this->createNotFoundException('Unable to find any survey.');
            }

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate($surveys,$this->get('request')->query->get('page', 1)/*page number*/,5/*limit per page*/);

            return $this->render('SondageSurveyBundle:Survey:list_survey.html.twig', array(
                'pagination'   => $pagination,
            ));
        }
        else {
            throw new AccessDeniedException();
        }
    }
}
