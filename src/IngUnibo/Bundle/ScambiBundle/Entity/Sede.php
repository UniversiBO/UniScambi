<?php

namespace IngUnibo\Bundle\ScambiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sede
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Sede
{

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     * @ORM\Id
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="Corso", mappedBy="sede")
     */
    private $corsi;

    /**
     * Set nome
     *
     * @param string $nome
     * @return Sede
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
     * Constructor
     */
    public function __construct()
    {
        $this->corsi = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add corsi
     *
     * @param \IngUnibo\Bundle\ScambiBundle\Entity\Corso $corsi
     * @return Dipartimento
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