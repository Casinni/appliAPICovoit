<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use App\Entity\Ville;
use App\Entity\Personne;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
   /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville",cascade={"persist"})
     * @ORM\JoinColumn(name="villed_id", referencedColumnName="id") 
     */ 
    private Ville $ville_dep;
    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville",cascade={"persist"})
     * @ORM\JoinColumn(name="villea_id", referencedColumnName="id") 
     */ 
     
    private Ville $ville_arr;
     /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Personne",cascade={"persist"})
     * @ORM\JoinColumn(name="pers_id", referencedColumnName="id") 
     */
    private $pers;
    /**
     * @ORM\Column(type="integer")
     */
    private $nbKms;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetrajet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbKms(): ?int
    {
        return $this->nbKms;
    }

    public function setNbKms(int $nbKms): self
    {
        $this->nbKms = $nbKms;

        return $this;
    }

    public function getDatetrajet(): ?\DateTimeInterface
    {
        return $this->datetrajet;
    }

    public function setDatetrajet(\DateTimeInterface $datetrajet): self
    {
        $this->datetrajet = $datetrajet;

        return $this;
    }

    public function getVilleDep(): ?Ville
    {
        return $this->ville_dep;
    }

    public function setVilleDep(?Ville $ville_dep): self
    {
        $this->ville_dep = $ville_dep;

        return $this;
    }

    public function getVilleArr(): ?Ville
    {
        return $this->ville_arr;
    }


    public function setVilleArr(?Ville $ville_arr): self
    {
        $this->ville_arr = $ville_arr;

        return $this;
    }

    public function setPers(?Personne $pers): self
    {
        $this->pers = $pers;

        return $this;
    }
    public function getPers(): ?Personne
    {
        return $this->pers;
    }
    public function __toString()
    {
        $data=array(
            'id'=>$this->getId(),
            'ville_dep'=>$this->getVilleDep()->__toString(),
            'ville_arr'=>$this->getVilleArr()->__toString(),
            'nbKms'=>$this->getNbKms(),
            'DateTrajet'=>$this->getDatetrajet()->format('d-m-Y h:i'),
            'id_pers'=>$this->getPers()->getId()
             );
                return $data;
    

    }

   
}
