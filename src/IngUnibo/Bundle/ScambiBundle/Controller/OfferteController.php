<?php

namespace IngUnibo\Bundle\ScambiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IngUnibo\Bundle\ScambiBundle\Entity\Corso;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class OfferteController extends Controller
{
    public function corsoAction($id)
    {
        $corso = $this->getDoctrine()->getRepository('IngUniboScambiBundle:Corso')->find($id);
        $conn = $this->container->get('database_connection');

		$em = $this->getDoctrine()->getManager();
        $query_tot_posti = $em->createQuery(
            'SELECT SUM(o.posti) tot_posti
            FROM IngUniboScambiBundle:Offerta o JOIN o.corsi c WHERE c.id = :id'
        )->setParameter('id', $id);  
        $tot_posti = $query_tot_posti->getSingleScalarResult();      

        $query = $em->createQuery(
            'SELECT o
            FROM IngUniboScambiBundle:Offerta o JOIN o.corsi c WHERE c.id = :id'
        )->setParameter('id', $id);

        if($this->get('request')->query->get('export')=='csv'){
            $offerte = $query->getResult();
            $engine = $this->container->get('templating');
            $content = $engine->render('IngUniboScambiBundle:Offerte:export.csv.twig', array('offerte' => $offerte));            
            
            $response = new Response(
                $content,
                200,
                array('content-type' => 'text/csv')
            );            
            $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'export.csv');
            $response->headers->set('Content-Disposition', $d); 
            return $response;           
        }


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:Offerte:corso.html.twig', array('pagination' => $pagination, 'corso' => $corso, 'tot_posti' => $tot_posti));
    }    

    public function dipartimentoAction($id)
    {
        $dipartimento = $this->getDoctrine()->getRepository('IngUniboScambiBundle:Dipartimento')->find($id);

        $em = $this->getDoctrine()->getManager();
        
        $conn = $this->container->get('database_connection');
        $sql = "SELECT SUM(a.posti) tot_posti FROM
(SELECT 
  DISTINCT(o0_.id), o0_.posti
FROM 
  Offerta o0_ 
  INNER JOIN offerte_corsi o2_ ON o0_.id = o2_.offerta_id 
  INNER JOIN Corso c1_ ON c1_.id = o2_.corso_id 
WHERE 
  c1_.dipartimento_nome = ?) a;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $tot_posti = $stmt->fetch()['tot_posti'];    

        $query = $em->createQuery(
            'SELECT o
            FROM IngUniboScambiBundle:Offerta o JOIN o.corsi c WHERE c.dipartimento = :id'
        )->setParameter('id', $id);

        if($this->get('request')->query->get('export')=='csv'){
            $offerte = $query->getResult();
            $engine = $this->container->get('templating');
            $content = $engine->render('IngUniboScambiBundle:Offerte:export.csv.twig', array('offerte' => $offerte));            
            
            $response = new Response(
                $content,
                200,
                array('content-type' => 'text/csv')
            );            
            $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'export.csv');
            $response->headers->set('Content-Disposition', $d); 
            return $response;           
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:Offerte:dipartimento.html.twig', array('pagination' => $pagination, 'dipartimento' => $dipartimento, 'tot_posti' => $tot_posti));
    }    

    public function sedeAction($id)
    {
        $sede = $this->getDoctrine()->getRepository('IngUniboScambiBundle:Sede')->find($id);

        $em = $this->getDoctrine()->getManager();
        
        $conn = $this->container->get('database_connection');
        $sql = "SELECT SUM(a.posti) tot_posti FROM
(SELECT 
  DISTINCT(o0_.id), o0_.posti
FROM 
  Offerta o0_ 
  INNER JOIN offerte_corsi o2_ ON o0_.id = o2_.offerta_id 
  INNER JOIN Corso c1_ ON c1_.id = o2_.corso_id 
WHERE 
  c1_.sede_nome = ?) a;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $tot_posti = $stmt->fetch()['tot_posti'];    

        $query = $em->createQuery(
            'SELECT o
            FROM IngUniboScambiBundle:Offerta o JOIN o.corsi c WHERE c.sede = :id'
        )->setParameter('id', $id);

        if($this->get('request')->query->get('export')=='csv'){
            $offerte = $query->getResult();
            $engine = $this->container->get('templating');
            $content = $engine->render('IngUniboScambiBundle:Offerte:export.csv.twig', array('offerte' => $offerte));            
            
            $response = new Response(
                $content,
                200,
                array('content-type' => 'text/csv')
            );            
            $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'export.csv');
            $response->headers->set('Content-Disposition', $d); 
            return $response;           
        }  

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:Offerte:sede.html.twig', array('pagination' => $pagination, 'sede' => $sede, 'tot_posti' => $tot_posti));
    }      
}
