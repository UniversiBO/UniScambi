<?php

namespace IngUnibo\Bundle\ScambiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IngUnibo\Bundle\ScambiBundle\Entity\Corso;
use Symfony\Component\HttpFoundation\Session\Session;

class BasketController extends Controller
{

    public function addAction($key,$callback)
    {
        $session = new Session();
        $session->start();
        $basket = $session->get('basket');
        if(!is_array($basket)){
            $basket = array();
        }
        if(!in_array($key, $basket)){
            $basket[] = $key;
            $session->set('basket', $basket);
        }

        return $this->redirect($this->generateUrl($callback));
    }

    public function remAction($key,$callback)
    {
        $session = new Session();
        $session->start();
        $basket = $session->get('basket');
        if(in_array($key, $basket)){
            $basket = array_diff($basket, array($key));
            $session->set('basket', $basket);
        }        

		return $this->redirect($this->generateUrl($callback));
    }

    public function listAction($callback){
        $basket = $this->getRequest()->getSession()->get('basket');
        if(!is_array($basket)) $basket = array();
        return $this->render('IngUniboScambiBundle:Basket:list.html.twig', array('basket' => $basket, 'callback' => $callback));
    }    

    public function unionAction()
    {
        $session = new Session();
        $session->start();
        $basket = $session->get('basket');

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
  ";

        $dsql = 'SELECT o FROM IngUniboScambiBundle:Offerta o JOIN o.corsi c WHERE (';
        $dat_key = array(
            'Corso' => 'id',
            'Dipartimento' => 'dipartimento',
            'Sede' => 'sede'
            );
        $mah_key = array(
            'Corso' => 'c1_.id',
            'Dipartimento' => 'c1_.dipartimento_nome',
            'Sede' => 'c1_.sede_nome'
            );        
        $i=1;
        foreach ($basket as $item) {
            $exploded = explode(':',$item);
            $key_dsql = $dat_key[$exploded[0]];
            $key_sql = $mah_key[$exploded[0]];
            $val[$i] = $exploded[1];
            $dsql .= " c.$key_dsql = ?$i OR ";
            $sql .= " $key_sql = ? OR ";
            $i++;
        }
        $dsql .= '0 = 1)';
        $sql .= '0 = 1) a;';
        $stmt = $conn->prepare($sql);
        $query = $em->createQuery($dsql);
        for($j=1;$j<$i;$j++){
            $query->setParameter($j,$val[$j]);
            $stmt->bindValue($j, $val[$j]);
        }

        if($this->get('request')->query->get('export')=='excel'){
            
        }

        $stmt->execute();
        $tot_posti = $stmt->fetch()['tot_posti']; 

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            50/*limit per page*/
        );        
        
        return $this->render('IngUniboScambiBundle:Basket:union.html.twig', array('pagination' => $pagination, 'tot_posti' => $tot_posti));
    }

    public function emptyAction($callback){
        $session = new Session();
        $session->start();
        $basket = array();
        $basket = $session->set('basket', $basket);
        return $this->redirect($this->generateUrl($callback));
    }          
}
