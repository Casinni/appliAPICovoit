<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ville;

class VilleController extends AbstractController
{
   /**
     * @Route("/insertVille/{ville}/{cp}", name="insertVille",requirements={"ville"="[a-z]{3,30}","cp"="[0-9]{5}"})
     */
    public function insert(Request $request,$ville,$cp)
    {

           $vil=new Ville();
           $vil->setVille($ville);
           $vil->setCodePostal($cp);

        if($request->isMethod('get')){
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
            
            $em->persist($vil);
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
    * @Route("/deleteVille/{id}", name="deleteVille",requirements={"id"="[0-9]{1,5}"})
    */
    public function delete(Request $request,$id)
    {
         //récupération du Manager  et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
          //requete de selection
        $vil=$villeRepository->find($id);
        //suppression de l'entity
        $em->remove($vil);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;

    }
      /**
     * @Route("/listeVille", name="listeVille")
     */
    public function liste(Request $request)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
    //VilleRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVilles=$villeRepository->findAll();
        $resultat=[];
		foreach($listeVilles as $vil){
            array_push($resultat,[$vil->getId()=>$vil->getVille()]);
		
		}
		$reponse=new JsonResponse($resultat);

        return $reponse;
    }
     /**
     * @Route("/listeCodePostal", name="listeCodePostal")
     */
    public function listeCP(Request $request)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
    //VilleRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVilles=$villeRepository->findAll();
        $resultat=[];
		foreach($listeVilles as $vil){
            array_push($resultat,[$vil->getId()=>$vil->getCodePostal()]);
		
		}
		$reponse=new JsonResponse($resultat);	
        return $reponse;
    }

}
