<?php

namespace IngUnibo\Bundle\ScambiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offerta
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Offerta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="posti", type="integer")
     */
    private $posti;

    /**
     * @var string
     *
     * @ORM\Column(name="nazione", type="string", length=255)
     */
    private $nazione;

    /**
     * @var string
     *
     * @ORM\Column(name="ragsociale", type="string", length=255)
     */
    private $ragsociale;

    /**
     * @ORM\ManyToMany(targetEntity="Corso", inversedBy="offerte")
     * @ORM\JoinTable(name="offerte_corsi")
     */
    private $corsi;

    public function __construct() {
        $this->corsi = new \Doctrine\Common\Collections\ArrayCollection();
    }    


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set posti
     *
     * @param integer $posti
     * @return Offerta
     */
    public function setPosti($posti)
    {
        $this->posti = $posti;
    
        return $this;
    }

    /**
     * Get posti
     *
     * @return integer 
     */
    public function getPosti()
    {
        return $this->posti;
    }

    /**
     * Set nazione
     *
     * @param string $nazione
     * @return Offerta
     */
    public function setNazione($nazione)
    {
        $this->nazione = $nazione;
    
        return $this;
    }

    /**
     * Get nazione
     *
     * @return string 
     */
    public function getNazione()
    {
        return $this->nazione;
    }

    /**
     * Set ragsociale
     *
     * @param string $ragsociale
     * @return Offerta
     */
    public function setRagsociale($ragsociale)
    {
        $this->ragsociale = $ragsociale;
    
        return $this;
    }

    /**
     * Get ragsociale
     *
     * @return string 
     */
    public function getRagsociale()
    {
        return $this->ragsociale;
    }

    /**
     * Add corsi
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Corso $corsi
     * @return Offerta
     */
    public function addCorsi(\IngUnibo\Bundle\ScambiBundle\Entity\Corso $corsi)
    {
        $this->corsi[] = $corsi;
    
        return $this;
    }

    /**
     * Remove corsi
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Corso $corsi
     */
    public function removeCorsi(\IngUnibo\Bundle\ScambiBundle\Entity\Corso $corsi)
    {
        $this->corsi->removeElement($corsi);
    }

    /**
     * Get corsi
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCorsi()
    {
        return $this->corsi;
    }
}