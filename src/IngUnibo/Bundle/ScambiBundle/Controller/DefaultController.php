<?php

namespace IngUnibo\Bundle\ScambiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IngUnibo\Bundle\ScambiBundle\Entity\Corso;

class DefaultController extends Controller
{
    public function indexAction()
    {	   
        return $this->redirect('IngUniboScambiBundle:List:corsi');
    }
}
