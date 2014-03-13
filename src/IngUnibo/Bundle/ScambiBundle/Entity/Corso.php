<?php

namespace IngUnibo\Bundle\ScambiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Corso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Corso
{

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=4)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Dipartimento", inversedBy="corsi")
     * @ORM\JoinColumn(name="dipartimento_nome", referencedColumnName="nome")
     */    
    private $dipartimento;

    /**
     * @ORM\ManyToOne(targetEntity="Sede", inversedBy="corsi")
     * @ORM\JoinColumn(name="sede_nome", referencedColumnName="nome")
     */    
    private $sede;    

    /**
     * @ORM\ManyToMany(targetEntity="Offerta", mappedBy="corsi")
     */
    private $offerte;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->offerte = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param string $id
     * @return Corso
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Corso
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    
        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set dipartimento
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Dipartimento $dipartimento
     * @return Corso
     */
    public function setDipartimento(\IngUnibo\Bundle\ScambiBundle\Entity\Dipartimento $dipartimento = null)
    {
        $this->dipartimento = $dipartimento;
    
        return $this;
    }

    /**
     * Get dipartimento
     *
     * @return \IngUnibo\Bundle\ScambiBundle\Entity\Dipartimento 
     */
    public function getDipartimento()
    {
        return $this->dipartimento;
    }

    /**
     * Add offerte
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Offerta $offerte
     * @return Corso
     */
    public function addOfferte(\IngUnibo\Bundle\ScambiBundle\Entity\Offerta $offerte)
    {
        $this->offerte[] = $offerte;
    
        return $this;
    }

    /**
     * Remove offerte
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Offerta $offerte
     */
    public function removeOfferte(\IngUnibo\Bundle\ScambiBundle\Entity\Offerta $offerte)
    {
        $this->offerte->removeElement($offerte);
    }

    /**
     * Get offerte
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfferte()
    {
        return $this->offerte;
    }

    /**
     * Set sede
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Sede $sede
     * @return Corso
     */
    public function setSede(\IngUnibo\Bundle\ScambiBundle\Entity\Sede $sede = null)
    {
        $this->sede = $sede;
    
        return $this;
    }

    /**
     * Get sede
     *
     * @return \IngUnibo\Bundle\ScambiBundle\Entity\Sede 
     */
    public function getSede()
    {
        return $this->sede;
    }
}