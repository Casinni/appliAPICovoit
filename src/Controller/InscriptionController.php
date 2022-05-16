<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Inscription;
use App\Entity\Personne;
use App\Entity\Trajet;

class InscriptionController extends AbstractController
{
      /**
     * @Route("/listeInscription", name="listeInscription")
     */
    public function liste(Request $request)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $inscriptionRepository=$em->getRepository(Inscription::class);
    //inscriptionRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        try{
        $listeIns=$inscriptionRepository->findAll();
        $resultat=[];
		foreach($listeIns as $ins){
			array_push($resultat,[$ins->__toString()]);
		}
    }catch(\Exception $e){
        $resultat=["pas de reservation"];
    }
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
     /**
     * @Route("/listeInscriptionConducteur/{idtrajet}", name="listeInscriptionConducteur",requirements={"idtrajet"="[0-9]{1,30}"})
     */
    public function listeConducteur(Request $request,$idtrajet)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $inscriptionRepository=$em->getRepository(Inscription::class);
    //inscriptionRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        try{
        $listeIns=$inscriptionRepository->findBy(['trajet' => $idtrajet]);
        $resultat=[];
		foreach($listeIns as $ins){
			array_push($resultat,[$ins->TrajetToString()]);
		}
    }catch(\Exception $e){
        $resultat=["pas de reservation"];
    }
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
     /**
     * @Route("/listeInscriptionUser/{idpers}", name="listeInscriptionUser",requirements={"idpers"="[0-9]{1,30}"})
     */
    public function listeUser(Request $request, $idpers)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $inscriptionRepository=$em->getRepository(Inscription::class);
    //inscriptionRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        try{
   
        $listeIns=$inscriptionRepository->findBy(['pers' => $idpers]);
        $resultat=[];
		foreach($listeIns as $ins){
			array_push($resultat,[$ins->UsertoString()]);
		}
    }catch(\Exception $e){
        $resultat=["pas de reservation"];
    }
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
     /**
     * @Route("/insertInscription/{idpers}/{idtrajet}", name="insertInscription",requirements={"idpers"="[0-9]{1,30}","idtrajet"="[0-9]{1,30}"})
     */
    public function insert(Request $request,$idpers,$idtrajet)
    {

           $ins=new Inscription();

        if($request->isMethod('get')){
      
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
 
        
            $persRepository=$em->getRepository(Personne::class);
             //requete de selection pour l'objet pers
           $p=$persRepository->find($idpers);
          

           $ins->setPers($p);
           $trajetRepository=$em->getRepository(Trajet::class);
           $traj=$trajetRepository->find($idtrajet);
           $ins->setTrajet($traj);
        //controle nbplace
             $insRepository=$em->getRepository(Inscription::class);
             $inscr=$insRepository->findBy(['trajet' => $idtrajet]);
             $i=0;
             foreach($inscr as $insa){
                $i++;
            }
            if($traj->getPers()->getVoiture()->getNbPlace()>$i){
            try{          
                 $em->persist($ins);
            //insertion en bdd
            $em->flush();
            $resultat=["OK"];
        } catch(\Exception $e){
            $resultat=["NOK"];
        }
        }else
        $resultat=["NOK"];
        }
        else {
            $resultat=["NOK"];
        }         
        $reponse=new JsonResponse($resultat);
        return $reponse;
     
    }
    /**
    * @Route("/deleteInscription/{id}", name="deleteInscription",requirements={"id"="[0-9]{1,5}"})
    */
    public function delete(Request $request,$id)
    {
         //récupération du Manager  et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $insRepository=$em->getRepository(Inscription::class);
          //requete de selection
          try{
        $in=$insRepository->find($id);
        //suppression de l'entity
        $em->remove($in);
        $em->flush();
        $resultat=["OK"];
    }catch(\Exception $e){
        $resultat=["NOK"];
    }
       
        $reponse=new JsonResponse($resultat);
        return $reponse;

    }
}
