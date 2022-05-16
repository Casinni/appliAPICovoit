<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Entity\Ville;
use App\Entity\Personne;
use App\Entity\Inscription;
use DateTime;

class TrajetController extends AbstractController
{
   /**
     * @Route("/listeTrajet", name="listTrajet")
     */
    public function liste(Request $request)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $trajetRepository=$em->getRepository(Trajet::class);
    //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeTrajets=$trajetRepository->findAll();
        $resultat=[];
		foreach($listeTrajets as $traj){
			array_push($resultat,[$traj->__toString()]);
		}
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
     /**
     * @Route("/rechercheTrajet/{villeD}/{villeA}/{dateT}", name="rechercheTrajet",requirements={"villeD"="[0-9]{1,10}","villeA"="[0-9]{1,10}","dateT"="[a-z0-9\- :]{3,30}"})
     */
    public function recherche(Request $request,$villeD,$villeA,$dateT){

       //conversion de la date en datetime
       $d=new DateTime($dateT);
    //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
       // $trajetRepository=$em->getRepository(Trajet::class);
        $q=$em->createQuery('select t from App\Entity\Trajet t where t.ville_arr= :va and t.ville_dep= :vd and t.datetrajet>=:d')
        ->setParameter('va',$villeA)
        ->setParameter('d',$d)
        ->setParameter('vd',$villeD);
        $listeTrajets=$q->getResult();
        $resultat=[];
		foreach($listeTrajets as $traj){
			array_push($resultat,[$traj->__toString()]);
		}
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
     /**
     * @Route("/insertTrajet/{kms}/{idpers}/{dateT}/{villeD}/{villeA}", name="insertTrajet",requirements={"kms"="[0-9]{3,30}","idpers"="[0-9]{1,10}","dateT"="[a-z0-9\- :]{3,30}","villeD"="[0-9]{1,10}","villeA"="[0-9]{1,10}"})
     */
    public function insert(Request $request,$kms,$idpers,$dateT,$villeD,$villeA)
    {

           $traj=new Trajet();

           $traj->setNbkms($kms);
           //conversion de la daye en datetime
           $d=new DateTime($dateT);
           $traj->setDatetrajet($d);
       
        

        if($request->isMethod('get')){
      
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
         
            //recuperation de l'enreg de la table user par le token
          //  $u=$userRepository->findOneBy(['apiToken' => $token]);
          $persRepository=$em->getRepository(Personne::class);
             //requete de selection pour l'onbjet ville
           $persArr=$persRepository->find($idpers);
           $traj->setPers($persArr);
            $villeRepository=$em->getRepository(Ville::class);
             //requete de selection pour l'onbjet ville
           $vilArr=$villeRepository->find($villeA);
           $traj->setVilleArr($vilArr);
           $vilDep=$villeRepository->find($villeD);
           $traj->setVilleDep($vilDep);
            $em->persist($traj);
            //insertion en bdd
            $em->flush();
            $resultat=["OK"];
        }
        else {
            $resultat=["NOK"];
        }         
        $reponse=new JsonResponse($resultat);
        return $reponse;
     
    }
    /**
    * @Route("/deleteTrajet/{id}", name="deleteTrajet",requirements={"id"="[0-9]{1,5}"})
    */
    public function delete(Request $request,$id)
    {
         //récupération du Manager  et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
      //supression resa
      $resaRepository=$em->getRepository(Inscription::class);
      $listeResa=$resaRepository->findBy(['trajet' => $id]);
      foreach($listeResa as $resa){
        $em->remove($resa);
       
      }
        $trajetRepository=$em->getRepository(trajet::class);
          //requete de selection
        $traj=$trajetRepository->find($id);
        //suppression de l'entity
        $em->remove($traj);
        $em->flush();
        $resultat=["OK"];
        $reponse=new JsonResponse($resultat);
        return $reponse;

    }
}
