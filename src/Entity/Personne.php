<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use App\Entity\Ville;
use App\Entity\Voiture;
use App\Entity\User;
use App\Entity\Trajet;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @ORM\OneToOne(targetEntity="App\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private User $user;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville",cascade={"persist"})
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")
     */
    private Ville $ville;
      /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture",cascade={"persist"})
     * @ORM\JoinColumn(name="voiture_id", referencedColumnName="id") 
     */
    private ?Voiture $voiture=null;
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateNaiss;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $email;

    public function __construct()
    {
        $this->trajet = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(?\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }
    public function __toString()
  {
      if(is_null($this->getVoiture())){
          $data=array(
              'prenom'=>$this->getNom(),
              'nom'=>$this->getPrenom(),
              'tel'=>$this->getTel(),
              'email'=>$this->getEmail(),
              'ville'=>$this->getVille()->__toString()
               );
   
        }
        else
        $data=array(
            'id'=>$this->getId(),
            'nom'=>$this->getNom(),
            'prenom'=>$this->getPrenom(),
            'tel'=>$this->getTel(),
            'email'=>$this->getEmail(),
            'ville'=>$this->getVille()->__toString(),
            'nb_places'=>$this->getVoiture()->getNbPlace(),
            'marque'=>$this->getVoiture()->getMarque()->getNom(),
            "modele"=>$this->getVoiture()->getModele(),
             );


        return $data;

}

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   
}
