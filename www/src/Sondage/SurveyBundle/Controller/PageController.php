<?php

namespace Sondage\SurveyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
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
        return $this->render('SondageSurveyBundle:Page:index.html.twig', array(
            'slideshow_pictures' => $slideshow_pictures->getResult(),
        ));
    }
}
