<?php

namespace App\Controller;
use App\Entity\Personne;
use App\Entity\Ville;
use App\Entity\Voiture;
use App\Entity\Marque;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/listePersonne", name="listPersonne")
     */
    public function liste(Request $request)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $personneRepository=$em->getRepository(Personne::class);
    //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listePersonnes=$personneRepository->findAll();
        $resultat=[];
		foreach($listePersonnes as $pers){
			array_push($resultat,[$pers->getId()=>$pers->__toString()]);
		}
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
    
     /**
     * @Route("/insertPersonne/{prenom}/{nom}/{tel}/{email}/{ville}/{voiture}", name="insertPersonne",requirements={"prenom"="[a-z]{3,30}","nom"="[a-z]{3,30}","tel"="[0-9]{10}","email"="[a-z.@]{4,30}","ville"="[0-9]{1,3}","voiture"="[0-9]{1,3}"})
     */
    public function insert(Request $request,$prenom,$nom,$tel,$email,$ville,$voiture)
    {

           $pers=new Personne();
           $pers->setPrenom($prenom);
           $pers->setNom($nom);
           $pers->setTel($tel);
           $pers->setEmail($email);

        if($request->isMethod('get')){
            //recuperation du token du headers
            $token=$request->headers->get('x-auth-token');
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
            //requete de selection pour user
            $userRepository=$em->getRepository(User::class);
            //recuperation de l'enreg de la table user par le token
            $u=$userRepository->findOneBy(['apiToken' => $token]);
            if($u){
                $pers->setUser($u);
            }
            $villeRepository=$em->getRepository(Ville::class);
             //requete de selection pour l'onbjet ville
           $vil=$villeRepository->find($ville);
           $pers->setVille($vil);
           $voitureRepository=$em->getRepository(Voiture::class);
           //requete de selection pour l'onbjet voiture
             $voit=$voitureRepository->find($voiture);
             $pers->setVoiture($voit);
            $em->persist($pers);
            //insertion en bdd
            $em->flush();
            $resultat=["ok"];
        }
        else {
            $resultat=["nok"];
        }         
        $reponse=new JsonResponse($resultat);
        return $reponse;
     
    }
    /**
    * @Route("/deletePersonne/{id}", name="deletePersonne",requirements={"id"="[0-9]{1,5}"})
    */
    public function delete(Request $request,$id)
    {
         //récupération du Manager  et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $personneRepository=$em->getRepository(Personne::class);
          //requete de selection
        $pers=$personneRepository->find($id);
        //suppression de l'entity
        $em->remove($pers);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;

    }
     /**
    * @Route("/selectPersonne/{id}", name="selectPersonne",requirements={"id"="[0-9]{1,5}"})
    */
    public function selectPers(Request $request,$id)
    {
         //récupération du Manager  et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $personneRepository=$em->getRepository(Personne::class);
          //requete de selection
       // $pers=$personneRepository->findOneBy(['id' => $id]);
       $pers=$personneRepository->find($id);
        $reponse=new JsonResponse($pers->__toString());
        return $reponse;

    }

    /**
     * @Route("/updatePersonne/{prenom}/{nom}/{tel}/{email}/{marque}/{modele}/{nbplaces}/{idpers}", name="updatePersonne",requirements={"prenom"="[a-z]{3,30}","nom"="[a-z]{3,30}","tel"="[0-9]{10}","email"="[a-z.@]{4,30}","marque"="[0-9]{1,3}","modele"="[a-z0-9]{1,40}","nbplaces"="[0-9]{1,2}","idpers"="[0-9]{1,3}"})
     */
    public function updatePers(Request $request,$prenom,$nom,$tel,$email,$marque,$modele,$nbplaces,$idpers)
    {

        if($request->isMethod('get')){
           
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
            //requete update
            $q=$em->createQuery('update  App\Entity\Personne p SET p.nom=:n, p.prenom=:pr,p.tel=:t, p.email=:e where p.id=:i')
            ->setParameter('n',$nom)
            ->setParameter('pr',$prenom)
            ->setParameter('t',$tel)
            ->setParameter('e',$email)
            ->setParameter('i',$idpers);
            $q->execute();

          if(!empty($marque)&& !empty($modele)&& !empty($nbplaces)){
           //requete insertion pour l'objet voiture
             $voit=new Voiture();
             $voit->setModele($modele);
             $voit->setNbPlace($nbplaces);
              //récupération de l'entityManager pour insérer les données en bdd
              $marqueRepository=$em->getRepository(Marque::class);
              //requete de selection pour l'onbjet marque
               $marq=$marqueRepository->find($marque);
               //affectaiton à l'objet voiture
               $voit->setMarque($marq);
               //
              $em->persist($voit);
              $em->flush();
            //update voiture personne
             //requete update
             $q=$em->createQuery('update  App\Entity\Personne p SET p.voiture=:v where p.id=:i')
             ->setParameter('v',$voit->getId())
             ->setParameter('i',$idpers);
             $q->execute();





            //insertion en bdd
            $em->flush();
            }
            $resultat=["ok"];
        }
        else {
            $resultat=["nok"];
        }         
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
