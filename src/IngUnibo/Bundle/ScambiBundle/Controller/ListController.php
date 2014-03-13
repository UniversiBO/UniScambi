<?php

namespace IngUnibo\Bundle\ScambiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IngUnibo\Bundle\ScambiBundle\Entity\Corso;
use Symfony\Component\HttpFoundation\Session\Session;

class ListController extends Controller
{
    public function corsiAction()
    {
        $session = new Session();
        $session->start();
        $basket = $session->get('basket');

        $em = $this->getDoctrine()->getManager();
        $search = $this->get('request')->query->get('search');
        if(!empty($search)) {
            $dql = "SELECT c FROM IngUniboScambiBundle:Corso c WHERE ((c.nome LIKE :search) OR (c.id LIKE :search))";
            $query = $em->createQuery($dql);
            $query->setParameter('search', '%' . $search . '%');
        } else {
            $dql = 'SELECT c
            FROM IngUniboScambiBundle:Corso c';
            $query = $em->createQuery($dql);            
        }        

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:List:corsi.html.twig', array('pagination' => $pagination, 'basket' => $basket, 'search' => $search));
    }

    public function sediAction()
    {
        $session = new Session();
        $session->start();
        $basket = $session->get('basket');
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT s
            FROM IngUniboScambiBundle:Sede s'
        );

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:List:sedi.html.twig', array('pagination' => $pagination, 'basket' => $basket));
    }

    public function dipartimentiAction()
    {
        $session = new Session();
        $session->start();
        $basket = $session->get('basket');

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT d
            FROM IngUniboScambiBundle:Dipartimento d'
        );

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:List:dipartimenti.html.twig', array('pagination' => $pagination, 'basket' => $basket));
    }        
}
