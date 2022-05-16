<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use App\Entity\Personne;
use App\Entity\Trajet;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 * @ORM\Table(name="inscription",uniqueConstraints={@ORM\UniqueConstraint(name="contrainte_trajet_pers",columns={"pers_id","trajet_id"})})
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
      /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Personne",cascade={"persist"})
     * @ORM\JoinColumn(name="pers_id", referencedColumnName="id") 
     */ 
    private Personne $pers;
    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Trajet",cascade={"persist"})
     * @ORM\JoinColumn(name="trajet_id", referencedColumnName="id") 
     */ 
    private Trajet $trajet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPers(): ?Personne
    {
        return $this->pers;
    }

    public function setPers(?Personne $pers): self
    {
        $this->pers = $pers;

        return $this;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }
    public function __toString()
    {
        $data=array(
            'id'=>$this->getId(),
            'personne'=>$this->getPers()->__toString(),
            'trajet'=>$this->getTrajet()->__toString()
             );
                return $data;
    

    }
    public function UsertoString()
    {
        $data=array(
            'id'=>$this->getId(),
            'trajet'=>$this->getTrajet()->__toString()
             );
                return $data;
    

    }
    public function TrajetToString()
    {
        $data=array(
            'id'=>$this->getId(),
            'personne'=>$this->getPers()->__toString()
             );
                return $data;
    

    }


}
